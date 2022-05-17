<?php

// Installer Contrl Panel:  src/components/pages/leads/BiddingTable.vue

(93): getStatistics(leadSaleType.name, leadTypes['STANDARD']).purchased;

(615):  getStatistics-> data = this.stateStatistics[leadTypeId].find(el => el.location.id === Number(this.stateLocationId));
        statistics = data.lead_sale_types.find(el => el.name === leadPriceType);
        return statistics ? statistics.statistics : null;

(365): stateStatistics: {},

(562): this.$set(this.stateStatistics, this.leadTypes["STANDARD"], resp[0].data.data.statistics);

(558): this.api.getLeadStatisticsInLocation(this.leadCampaignId, this.leadCategoryId, this.leadTypes["STANDARD"], stateLocationId),

// Installer Control Panel:  src/services/api/api.js

(674): getLeadStatisticsInLocation(leadCampaignId, leadCategoryId, leadTypeId, locationId) {
            return this.axios().get(`/companies/${this.companyId}/campaigns/${leadCampaignId}/locations/${locationId}/statistics`, {
                params: {
                    lead_category_id: leadCategoryId,
                    lead_type_id: leadTypeId
            }
        });
    }
    ]

// SolarReviews:  routes/client-api.php

(254): $router->get('/companies/{company_id}/campaigns/{campaign}/locations/{locations}/statistics', 'Statistics\LeadSalesTypeStatisticController@getStatisticsInLocation');

(99):    public function getStatisticsInLocation(int $companyId, string $campaignId, int $locationId, Request $request)
            {
                /** @var LeadCampaign $campaign */
                $campaign = LeadCampaign::query()->where(LeadCampaign::UUID, $campaignId)->firstOrFail();

                /** @var Location $location */
                $location = Location::query()->findOrFail($locationId);

                $company = $this->companyRepository->findOrFail($companyId);
                $leadIndustry = $company->isTypeRoofer() ? EloquentQuote::LEAD_INDUSTRY_ROOFING : EloquentQuote::LEAD_INDUSTRY_SOLAR;

                $request->query->set(self::FIELD_LEAD_CAMPAIGN_ID, $campaign->id);
                $request->query->set(self::FIELD_COMPANY_ID, $company->companyid);
                $request->query->set(self::FIELD_LOCATION_ID, $location->id);

                $data = $this->leadSalesTypeStatisticService->getByLeadCampaign(
                    $request->get(self::FIELD_LEAD_CAMPAIGN_ID),
                    $request->get(self::FIELD_COMPANY_ID),
                    $request->get(self::FIELD_LEAD_CATEGORY_ID),
                    $request->get(self::FIELD_LEAD_TYPE_ID),
                    [$location],
                    $leadIndustry
                );
                return $this->getResponseData([self::FIELD_STATISTICS => $data]);
            }

// app/Services/LeadStatistics/LeadSalesTypeStatisticService.php

(91):    public function getByLeadCampaign($leadCampaignId, $installerId, $leadCategoryId = null, $leadTypeId = null, $location = null, string $leadIndustry = EloquentQuote::LEAD_INDUSTRY_SOLAR)
            {
                $leadCampaign = $this->leadCampaignRepository->findById($leadCampaignId);
                $inputLocation = null;
                $statisticsData = array();

                if (is_array($location)) {
                    $locations = collect($location);
                } else {
                    if ($location) {
                        $inputLocation = $this->locationRepository->find($location);
                    }
                    $forCounties = !empty($location) && $inputLocation->isState();

                    if ($forCounties) {
                        $locations = $leadCampaign->locationService()->servicedCountiesInState($inputLocation->state_abbr)->values();
                    } else {
                        $locations = $leadCampaign->locationService()->servicedStates()->values();
                    }
                }

                /** @var Location $location */
                foreach ($locations as &$location) {
                    $data = [];
                    // NOTE: override correct location ID because it current fetch via pivot table so the ID is of lead_campaign_locations
                    $location->id = $location->location_id ?? $location->id;
                    $location->name = $location->getName();
                    $data[self::FIELD_LOCATION] = $location;
                    $data[self::FIELD_LEAD_SALE_TYPES] = $this->getDetail(
                        $leadCategoryId,
                        $leadTypeId,
                        $location->state_abbr,
                        $location->isCounty() ? $location->county_key : null,
                        $installerId,
                        $leadCampaign,
                        $leadIndustry
                    );
                    $data[self::FIELD_TOTAL_STATISTICS] = $this->sumStatisticSalesType($data[self::FIELD_LEAD_SALE_TYPES]);

                    $statisticsData[] = $data;
                }

                return $statisticsData;
            }

// getDetail Function from Line 89
//

    public function getDetail($leadCategoryId, $leadTypeId, $stateAbbr, $countyKey = null, $installerId = null, $leadCampaign = null, string $leadIndustry = EloquentQuote::LEAD_INDUSTRY_SOLAR)
{
    $availableFromTime = $this->getAverageAvailableLeadFromTime(1);
    $availableToTime = $this->getAverageAvailableLeadToTime();
    $purchasedFromTime = $this->getAveragePurchasedLeadFromTime();
    $purchasedToTime = $this->getAveragePurchasedLeadToTime();

    $cities = null;
    if ($stateAbbr && $countyKey) {
        if ($leadCampaign) {
            $cities = $leadCampaign->locationService()->servicedCitiesInCounty($stateAbbr, $countyKey)->values()->pluck(Location::CITY)->toArray();
        } else {
            $cities = $this->locationRepository->getCitiesInCounty($stateAbbr, $countyKey)->values()->pluck(Location::CITY)->toArray();
        }
    } else {
        // In-case find by state need to scope list county in state also
        if ($leadCampaign) {
            $cities = $leadCampaign->locationService()->servicedCitiesInState($stateAbbr)->values()->pluck(Location::CITY)->toArray();
        }
    }

    //Optional City Filter
    $cityFilter="";
    if(sizeof($cities)>0) {
        $cities = "'" . implode("', '", $cities) . "'";
        $cityFilter=" and address.".EloquentAddress::CITY." in (".$cities.")";
    }

    //Optional Industry Filter
    $industryFilter = "";
    if ($leadIndustry === EloquentQuote::LEAD_INDUSTRY_SOLAR) {
        $industryFilter = " and ".EloquentQuote::TABLE.".".EloquentQuote::SOLAR_LEAD." = 1";
    } elseif ($leadIndustry === EloquentQuote::LEAD_INDUSTRY_ROOFING) {
        $industryFilter = " and ".EloquentQuote::TABLE.".".EloquentQuote::ROOFING_LEAD." = 1";
    }

    //Optional Installer Filter
    $InstallerFilter = "";
    if(is_numeric($installerId)){
        $InstallerFilter = "and qc.".EloquentQuoteCompany::COMPANY_ID." = ".intval($installerId);
    }

    //Retrieve data to determine available/purchased for each lead type
    $leadTypeStatSql = "select
                   ".EloquentQuote::NUMBER_OF_QUOTES.",
                   ".EloquentQuote::PHONE_IS_VALIDATED_FLAG.",
                   ".EloquentQuote::TABLE.".".EloquentQuote::STATUS.",
                   ".EloquentQuote::TABLE.".".EloquentQuote::CLASSIFICATION.",
                   conf.".LeadCampaignSalesTypeConfiguration::LEAD_SALES_TYPE_ID.",
                   (length(".EloquentQuote::USER_EMAIL.") > 0) has_email,
                   !(address.".EloquentAddress::PHONE." = '' OR address.".EloquentAddress::PHONE." = 'email only') has_phone,
                   IF( conf.".LeadCampaignSalesTypeConfiguration::LEAD_CAMPAIGN_ID." IS NOT NULL && conf.".LeadCampaignSalesTypeConfiguration::LEAD_CAMPAIGN_ID." = ".intval($leadCampaign->id).", 1, 0 ) purchased
            from ".EloquentQuote::TABLE."
                left join ".EloquentAddress::TABLE." address on address.".EloquentAddress::ADDRESS_ID." = tblquote.".EloquentQuote::ADDRESS_ID."
                left join ".EloquentQuoteCompany::TABLE." qc on ".EloquentQuote::TABLE.".".EloquentQuote::QUOTE_ID." = qc.".EloquentQuoteCompany::QUOTE_ID."
                    ".$InstallerFilter."
                    and qc.".EloquentQuoteCompany::SOLD_STATUS." = '".EloquentQuoteCompany::VALUE_SOLD_STATUS_SOLD."'
                    and qc.".EloquentQuoteCompany::TIMESTAMP_INITIAL_DELIVERY." >=".intval($purchasedFromTime)."
                    and qc.".EloquentQuoteCompany::TIMESTAMP_INITIAL_DELIVERY." <=".intval($purchasedToTime)."
                left join ".LeadCampaignSalesTypeConfiguration::TABLE." conf on conf.".LeadCampaignSalesTypeConfiguration::ID." = qc.".EloquentQuoteCompany::LEAD_CAMPAIGN_SALES_TYPE_CONFIGURATION_ID."
            where ".EloquentQuote::TABLE.".".EloquentQuote::STATUS." IN ('".EloquentQuote::VALUE_STATUS_ALLOCATED."', '".EloquentQuote::VALUE_STATUS_NO_COMPANIES."', '".EloquentQuote::VALUE_STATUS_UNDER_REVIEW."')
              and ".EloquentQuote::TABLE.".".EloquentQuote::LEAD_CATEGORY_ID."=".intval($leadCategoryId)."
              and ".EloquentQuote::TABLE.".".EloquentQuote::LEAD_TYPE_ID."=".intval($leadTypeId)."
              and exists (
                    select * from ".EloquentAddress::TABLE."
                    where ".EloquentQuote::TABLE.".".EloquentQuote::ADDRESS_ID." = ".EloquentAddress::TABLE.".".EloquentAddress::ADDRESS_ID."
                    and ".EloquentAddress::TABLE.".".EloquentAddress::STATE_ABBR." = '".$stateAbbr."'
                )
              and ".EloquentQuote::TABLE.".".EloquentQuote::TIMESTAMP_ADDED." >= ".intval($availableFromTime)."
              and ".EloquentQuote::TABLE.".".EloquentQuote::TIMESTAMP_ADDED." <= ".intval($availableToTime)."
            ".$industryFilter."
            ".$cityFilter;

    $leads = collect(DB::select($leadTypeStatSql));

    $leadSalesTypes = $this->leadSalesTypeRepository->getActiveSalesTypes();

    // Allocated lead are counted as their respective sales type
    $allocatedLeads = $leads->filter(function($lead){return ($lead[LeadCampaignSalesTypeConfiguration::LEAD_SALES_TYPE_ID] != null);});
    foreach ($leadSalesTypes as $leadSalesType){
        // Available lead count includes leads purchased by the specified company/campaign
        $availableCount = $allocatedLeads->where(LeadCampaignSalesTypeConfiguration::LEAD_SALES_TYPE_ID, $leadSalesType->id)->count();
        $purchasedCount = $allocatedLeads->where(LeadCampaignSalesTypeConfiguration::LEAD_SALES_TYPE_ID, $leadSalesType->id)->where('purchased', 1)->count();
        $statistics[self::FIELD_AVAILABLE_LEAD] = $availableCount;
        $statistics[self::FIELD_PURCHASED_LEAD] = $purchasedCount;
        $leadSalesType->{self::FIELD_STATISTICS} = $statistics;
    }

    // Non-allocated leads are counted toward whichever sales type matches the requested quotes (i.e. 1 = 'Exclusive')
    $nonAllocatedLeads = $leads->filter(function($lead){return ($lead[LeadCampaignSalesTypeConfiguration::LEAD_SALES_TYPE_ID] == null);});
    foreach ($leadSalesTypes as $leadSalesType) {
        if($leadSalesType->isDefault()){
            $leads = $nonAllocatedLeads->filter(function($lead)use($leadSalesType){
                return (
                        $lead[EloquentQuote::CLASSIFICATION] === EloquentQuote::CLASSIFICATION_VERIFIED ||
                        (
                            $lead[EloquentQuote::CLASSIFICATION] === null &&
                            $lead['has_phone'] &&
                            $lead['has_email'] &&
                            $lead[EloquentQuote::PHONE_IS_VALIDATED_FLAG] === EloquentQuote::VALUE_PHONE_VALIDATED
                        )
                    ) && $lead[EloquentQuote::NUMBER_OF_QUOTES] === $leadSalesType->sale_limit;
            });
        }elseif ($leadSalesType->isUnverified()){
            $leads = $nonAllocatedLeads->filter(function($lead){
                return (
                    $lead[EloquentQuote::CLASSIFICATION] === EloquentQuote::CLASSIFICATION_UNVERIFIED ||
                    (
                        $lead[EloquentQuote::CLASSIFICATION] === null &&
                        $lead['has_phone'] &&
                        $lead['has_email'] &&
                        $lead[EloquentQuote::PHONE_IS_VALIDATED_FLAG] !== EloquentQuote::VALUE_PHONE_VALIDATED
                    )
                );
            });
        }elseif ($leadSalesType->isEmailOnly()){
            $leads = $nonAllocatedLeads->filter(function($lead){
                return (
                    $lead[EloquentQuote::CLASSIFICATION] === EloquentQuote::CLASSIFICATION_EMAIL_ONLY ||
                    (
                        $lead[EloquentQuote::CLASSIFICATION] === null &&
                        !$lead['has_phone'] &&
                        $lead['has_email']
                    )
                );
            });
        }else{
            $leads = collect();
        }
        $availableCount = $leads->count();
        $purchasedCount = $leads->where('purchased', 1)->count();
        $statistics = $leadSalesType->{self::FIELD_STATISTICS};
        $statistics[self::FIELD_AVAILABLE_LEAD] += $availableCount;
        $statistics[self::FIELD_PURCHASED_LEAD] += $purchasedCount;

        // If available ends up less than purchased, we will have them match instead of using an arbitrary multiplier to inflate available
        if($statistics[self::FIELD_AVAILABLE_LEAD] < $statistics[self::FIELD_PURCHASED_LEAD]){$statistics[self::FIELD_AVAILABLE_LEAD] = $statistics[self::FIELD_PURCHASED_LEAD];}
        $statistics[self::FIELD_PURCHASED_RATE_LEAD] = $this->preventDivByZero($statistics[self::FIELD_PURCHASED_LEAD] * 100, $statistics[self::FIELD_AVAILABLE_LEAD]);
        $leadSalesType->{self::FIELD_STATISTICS} = $statistics;
    }

    return $leadSalesTypes;

//sumStatisticSalesType


    private function sumStatisticSalesType($leadSalesTypes)
{
    $totalStatistics = [
        self::FIELD_AVAILABLE_LEAD => 0,
        self::FIELD_PURCHASED_LEAD => 0,
        self::FIELD_PURCHASED_RATE_LEAD => 0,
    ];

    foreach ($leadSalesTypes as $leadSalesType) {
        $totalStatistics[self::FIELD_AVAILABLE_LEAD] += $leadSalesType->{self::FIELD_STATISTICS}[self::FIELD_AVAILABLE_LEAD];
        $totalStatistics[self::FIELD_PURCHASED_LEAD] += $leadSalesType->{self::FIELD_STATISTICS}[self::FIELD_PURCHASED_LEAD];
    }

    $totalStatistics[self::FIELD_PURCHASED_RATE_LEAD] = $this->preventDivByZero($totalStatistics[self::FIELD_PURCHASED_LEAD] * 100, $totalStatistics[self::FIELD_AVAILABLE_LEAD]);

    return $totalStatistics;
}
