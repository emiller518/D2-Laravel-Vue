games_gameinfo = '''SELECT a.GameID, a.HomePts HomePoints, a.AwayPts AwayPoints, a.Ties NumTies, a.LeadChanges NumLeadChanges, a.Exhibition Exi,
                    a.Attendance Atnd,
                    home.Name hometeam, away.Name awayteam,
                    b.PointsOffTO HomePointsOffTO, b.SecondChance HomeSecondChance, b.PointsInPaint HomePointsInPaint, 
                    b.FastBreak HomeFastBreak, b.BenchPoints HomeBenchPoints, b.LargestLead HomeLargestLead, b.HalfOfLL HomeHalfOfLL, b.TimeOfLL HomeTimeOfLL,
                    c.PointsOffTO AwayPointsOffTO, c.SecondChance AwaySecondChance, c.PointsInPaint AwayPointsInPaint, 
                    c.FastBreak AwayFastBreak, c.BenchPoints AwayBenchPoints, c.LargestLead AwayLargestLead, c.HalfOfLL AwayHalfOfLL, c.TimeOfLL AwayTimeOfLL
                    From Game a
                    LEFT JOIN TeamStats b ON a.HomeID = b.TeamID and a.GameID = b.GameID
                    LEFT JOIN TeamStats c on a.AwayID = c.TeamID and a.GameID = c.GameID
                    LEFT JOIN Team home on a.HomeID = home.TeamID
                    LEFT JOIN Team away on a.AwayID = away.TeamID
                    WHERE a.GameID = %s;'''


games_homeplayerstats = '''SELECT * From
                            (SELECT
                            d.PlayerID,
                            case when d.Name = 'Team' then '' else d.PlayerID END pid, 
                            d.Name PlayerName, 
                            CAST(case when d.Name = 'Team' then '' else a.Minutes end as CHAR) Minutes, 
                            CAST(case when d.name = 'Team' and a.FGMade = 0 then '' else a.FGMade end as CHAR) FGMade, 
                            CAST(case when d.name = 'Team' and a.FGAttempts = 0 then '' else a.FGAttempts end as CHAR) FGAttempts, 
                            CAST(case when d.name = 'Team' and a.`3PMade` = 0 then '' else a.`3PMade` end as CHAR) `3PMade`, 
                            CAST(case when d.name = 'Team' and a.`3PAttempts` = 0 then '' else a.`3PAttempts` end as CHAR) `3PAttempts`, 
                            CAST(case when d.name = 'Team' and a.FTMade = 0 then '' else a.FTMade end as CHAR) FTMade, 
                            CAST(case when d.name = 'Team' and a.FTAttempts = 0 then '' else a.FTAttempts end as CHAR) FTAttempts, 
                            CAST(case when d.name = 'Team' and a.OffReb = 0 then '' else a.OffReb end as CHAR) OffReb, 
                            CAST(case when d.name = 'Team' and a.DefReb = 0 then '' else a.DefReb end as CHAR) DefReb, 
                            CAST(case when d.name = 'Team' and a.Rebounds = 0 then '' else a.Rebounds end as CHAR) Rebounds, 
                            CAST(case when d.name = 'Team' and a.Assists = 0 then '' else a.Assists end as CHAR) Assists, 
                            CAST(case when d.name = 'Team' and a.Steals = 0 then '' else a.Steals end as CHAR) Steals, 
                            CAST(case when d.name = 'Team' and a.Blocks = 0 then '' else a.Blocks end as CHAR) Blocks, 
                            CAST(case when d.name = 'Team' and a.Turnovers = 0 then '' else a.Turnovers end as CHAR) Turnovers, 
                            CAST(case when d.name = 'Team' and a.Fouls = 0 then '' else a.Fouls end as CHAR) Fouls, 
                            CAST(case when d.name = 'Team' and a.Points = 0 then '' else a.Points end as CHAR) Points, 
                            CAST(case when `a`.`Starter` = 1 then '*' else '' end as CHAR) Starter
                            From PlayerStats a
                            LEFT JOIN PlayerYear b ON a.PlayerID = b.PlayerID
                            LEFT JOIN Game c on c.GameID = a.GameID and c.HomeID = b.TeamID and c.SeasonID = b.SeasonID
                            LEFT JOIN Player d on a.PlayerID = d.PlayerID
                            WHERE a.GameID = %s
                            and c.GameID IS NOT NULL
                            union all
                            SELECT 
                            '', '', 'Totals' Name, '' Minutes, sum(e.FGMade), sum(e.FGAttempts), sum(e.`3PMade`), sum(e.`3PAttempts`), sum(e.FTMade), sum(e.FTAttempts), 
                            sum(e.OffReb), sum(e.DefReb), sum(e.Rebounds), sum(e.Assists), sum(e.Steals), sum(e.Blocks), sum(e.Turnovers), sum(e.Fouls), sum(e.Points), '' Starter
                            From PlayerStats e
                            LEFT JOIN PlayerYear b ON e.PlayerID = b.PlayerID
                            LEFT JOIN Game c on c.GameID = e.GameID and c.HomeID = b.TeamID and c.SeasonID = b.SeasonID
                            LEFT JOIN Player d on e.PlayerID = d.PlayerID
                            WHERE e.GameID = %s
                            and c.GameID IS NOT NULL
                            GROUP BY e.GameID
                            ) hometable
                            order by hometable.Starter desc, hometable.minutes desc, hometable.Fouls asc;'''

games_awayplayerstats = '''SELECT * From
                            (SELECT
                            d.PlayerID,
                            case when d.Name = 'Team' then '' else d.PlayerID END pid, 
                            d.Name PlayerName, 
                            CAST(case when d.Name = 'Team' then '' else a.Minutes end as CHAR) Minutes, 
                            CAST(case when d.name = 'Team' and a.FGMade = 0 then '' else a.FGMade end as CHAR) FGMade, 
                            CAST(case when d.name = 'Team' and a.FGAttempts = 0 then '' else a.FGAttempts end as CHAR) FGAttempts, 
                            CAST(case when d.name = 'Team' and a.`3PMade` = 0 then '' else a.`3PMade` end as CHAR) `3PMade`, 
                            CAST(case when d.name = 'Team' and a.`3PAttempts` = 0 then '' else a.`3PAttempts` end as CHAR) `3PAttempts`, 
                            CAST(case when d.name = 'Team' and a.FTMade = 0 then '' else a.FTMade end as CHAR) FTMade, 
                            CAST(case when d.name = 'Team' and a.FTAttempts = 0 then '' else a.FTAttempts end as CHAR) FTAttempts, 
                            CAST(case when d.name = 'Team' and a.OffReb = 0 then '' else a.OffReb end as CHAR) OffReb, 
                            CAST(case when d.name = 'Team' and a.DefReb = 0 then '' else a.DefReb end as CHAR) DefReb, 
                            CAST(case when d.name = 'Team' and a.Rebounds = 0 then '' else a.Rebounds end as CHAR) Rebounds, 
                            CAST(case when d.name = 'Team' and a.Assists = 0 then '' else a.Assists end as CHAR) Assists, 
                            CAST(case when d.name = 'Team' and a.Steals = 0 then '' else a.Steals end as CHAR) Steals, 
                            CAST(case when d.name = 'Team' and a.Blocks = 0 then '' else a.Blocks end as CHAR) Blocks, 
                            CAST(case when d.name = 'Team' and a.Turnovers = 0 then '' else a.Turnovers end as CHAR) Turnovers, 
                            CAST(case when d.name = 'Team' and a.Fouls = 0 then '' else a.Fouls end as CHAR) Fouls, 
                            CAST(case when d.name = 'Team' and a.Points = 0 then '' else a.Points end as CHAR) Points, 
                            CAST(case when `a`.`Starter` = 1 then '*' else '' end as CHAR) Starter
                            From PlayerStats a
                            LEFT JOIN PlayerYear b ON a.PlayerID = b.PlayerID
                            LEFT JOIN Game c on c.GameID = a.GameID and c.AwayID = b.TeamID and c.SeasonID = b.SeasonID
                            LEFT JOIN Player d on a.PlayerID = d.PlayerID
                            WHERE a.GameID = %s
                            and c.GameID IS NOT NULL
                            union all
                            SELECT 
                            '', '', 'Totals' Name, '' Minutes, sum(e.FGMade), sum(e.FGAttempts), sum(e.`3PMade`), sum(e.`3PAttempts`), sum(e.FTMade), sum(e.FTAttempts), 
                            sum(e.OffReb), sum(e.DefReb), sum(e.Rebounds), sum(e.Assists), sum(e.Steals), sum(e.Blocks), sum(e.Turnovers), sum(e.Fouls), sum(e.Points), '' Starter
                            From PlayerStats e
                            LEFT JOIN PlayerYear b ON e.PlayerID = b.PlayerID
                            LEFT JOIN Game c on c.GameID = e.GameID and c.AwayID = b.TeamID and c.SeasonID = b.SeasonID
                            LEFT JOIN Player d on e.PlayerID = d.PlayerID
                            WHERE e.GameID = %s
                            and c.GameID IS NOT NULL
                            GROUP BY e.GameID
                            ) awaytable
                            order by awaytable.Starter desc, awaytable.minutes desc, awaytable.Fouls asc;'''


games_lineupcheck = '''SELECT GameID, MAX(HomeLineup) lineupcheck From PlayByPlay WHERE GameID = %s group by GameID;'''



games_lineups = '''SELECT stats.GameID,
                    players.LineupID, 
                    players.pid1, players.lastname1,
                    players.pid2, players.lastname2,
                    players.pid3, players.lastname3,
                    players.pid4, players.lastname4,
                    players.pid5, players.lastname5,
                    stats.* FROM (
                    
                    SELECT * FROM (
                    SELECT 
                    LineupID,
                    Substring_index(Group_Concat(PlayerID),',',1) p1,
                    Substring_index(Substring_index(Group_Concat(PlayerID),',',2),',',-1) p2,
                    Substring_index(Substring_index(Group_Concat(PlayerID),',',3),',',-1) p3,
                    Substring_index(Substring_index(Group_Concat(PlayerID),',',4),',',-1) p4,
                    Substring_index(Substring_index(Group_Concat(PlayerID),',',5),',',-1) p5
                    FROM Lineup
                    Group By LineupID ) a
                    LEFT JOIN
                    ( SELECT PlayerID pid1, SUBSTRING(Name, LOCATE(' ', Name)) lastname1 From Player ) player1
                    on a.p1 = player1.pid1
                    LEFT JOIN
                    ( SELECT PlayerID pid2, SUBSTRING(Name, LOCATE(' ', Name)) lastname2 From Player  ) player2
                    on a.p2 = player2.pid2
                    LEFT JOIN
                    ( SELECT PlayerID pid3, SUBSTRING(Name, LOCATE(' ', Name)) lastname3 From Player  ) player3
                    on a.p3 = player3.pid3
                    LEFT JOIN
                    ( SELECT PlayerID pid4, SUBSTRING(Name, LOCATE(' ', Name)) lastname4 From Player  ) player4
                    on a.p4 = player4.pid4
                    LEFT JOIN
                    ( SELECT PlayerID pid5, SUBSTRING(Name, LOCATE(' ', Name)) lastname5 From Player  ) player5
                    on a.p5 = player5.pid5 ) players
                    INNER JOIN 
                    (
                    SELECT 
                    GameID,
                    HomeLineup LineupID,  'H' Team,
                    RIGHT(SEC_TO_TIME(SUM(SecondsTaken)), 5) MP,
                    SUM(CASE WHEN Team = 'H' THEN Points END) PointsScored,
                    SUM(Case WHEN Team = 'A' THEN Points END) PointsAllowed,
                    SUM(CASE WHEN Team = 'H' THEN FGM END) FGM,
                    SUM(CASE WHEN Team = 'H' THEN FGA END) FGA,
                    SUM(CASE WHEN Team = 'H' THEN `3PM` END) ThreePM,
                    SUM(CASE WHEN Team = 'H' THEN `3PA` END) ThreePA,
                    SUM(CASE WHEN Team = 'H' THEN FTM END) FTM,
                    SUM(CASE WHEN Team = 'H' THEN FTA END) FTA,
                    SUM(CASE WHEN Team = 'H' THEN Steal END) Steal,
                    SUM(CASE WHEN Team = 'H' THEN Assist END) Assist,
                    SUM(CASE WHEN Team = 'H' THEN Rebound END) Rebound,
                    SUM(CASE WHEN Team = 'H' THEN Block END) Block,
                    SUM(CASE WHEN Team = 'H' THEN Turnover END) Turnover,
                    SUM(CASE WHEN Team = 'H' THEN Foul END) Foul
                    From PlayByPlay 
                    LEFT JOIN PBPPlayType ON PlayByPlay.PlayTypeID = PBPPlayType.PlayTypeID 
                    WHERE GameID = %s
                    GROUP BY HomeLineup
                    
                    UNION ALL
                    
                    SELECT 
                    GameID,
                    AwayLineup LineupID,  'A' Team,
                    RIGHT(SEC_TO_TIME(SUM(SecondsTaken)), 5) MP,
                    SUM(CASE WHEN Team = 'A' THEN Points END) PointsScored,
                    SUM(Case WHEN Team = 'H' THEN Points END) PointsAllowed,
                    SUM(CASE WHEN Team = 'A' THEN FGM END) FGM,
                    SUM(CASE WHEN Team = 'A' THEN FGA END) FGA,
                    SUM(CASE WHEN Team = 'A' THEN `3PM` END) ThreePM,
                    SUM(CASE WHEN Team = 'A' THEN `3PA` END) ThreePA,
                    SUM(CASE WHEN Team = 'A' THEN FTM END) FTM,
                    SUM(CASE WHEN Team = 'A' THEN FTA END) FTA,
                    SUM(CASE WHEN Team = 'A' THEN Steal END) Steal,
                    SUM(CASE WHEN Team = 'A' THEN Assist END) Assist,
                    SUM(CASE WHEN Team = 'A' THEN Rebound END) Rebound,
                    SUM(CASE WHEN Team = 'A' THEN Block END) Block,
                    SUM(CASE WHEN Team = 'A' THEN Turnover END) Turnover,
                    SUM(CASE WHEN Team = 'A' THEN Foul END) Foul
                    From PlayByPlay 
                    LEFT JOIN PBPPlayType ON PlayByPlay.PlayTypeID = PBPPlayType.PlayTypeID 
                    WHERE GameID = %s
                    GROUP BY AwayLineup
                    
                    ) stats
                    ON players.LineupID = stats.LineupID;'''


games_pbp = '''SELECT a.PlayByPlayID, a.Time PlayTime, a.Seconds, a.Half,
                CASE WHEN Team = 'A' THEN a.PlayerID ELSE '' END AwayPID,
                CASE WHEN Team = 'A' THEN b.Name ELSE '' END AwayPlayer,
                CASE WHEN Team = 'A' THEN c.Name ELSE '' END AwayPlayType,
                a.AwayScore Away_Score, 
                CASE WHEN c.Points > 0 and Team = 'A' THEN CONCAT('(+', c.Points, ')') ELSE '' END AwayPoints,
                a.HomeScore Home_Score,
                CASE WHEN c.Points > 0 and Team = 'H' THEN CONCAT('(+', c.Points, ')') ELSE '' END HomePoints,
                CASE WHEN Team = 'H' THEN a.PlayerID ELSE '' END HomePID,
                CASE WHEN Team = 'H' THEN b.Name ELSE '' END HomePlayer,
                CASE WHEN Team = 'H' THEN c.Name ELSE '' END HomePlayType
                from PlayByPlay a 
                LEFT JOIN Player b on a.PlayerID = b.PlayerID
                LEFT JOIN PBPPlayType c ON a.PlayTypeID = c.PlayTypeID
                where a.GameID = %s;'''


player_avgbyyear = '''SELECT 
                    PlayerYear.PlayerID,
                    CASE WHEN Season.SeasonID < 10 
                    then concat(Team.Abbreviation, 0, Season.SeasonID, PlayerYear.PlayerID, '.jpg') 
                    else concat(Team.Abbreviation, Season.SeasonID, PlayerYear.PlayerID, '.jpg')  end image,
                    Season.Name Season,
                    Class.Abbreviation Year,
                    Team.Name Team,
                    Team.TeamID,
                    Team.Abbreviation,
                    PlayerYear.Position,
                    COUNT(DISTINCT PlayerStats.GameID) GP,
                    SUM(PlayerStats.Starter) GS,
                    ROUND(AVG(PlayerStats.Minutes),1) AS MIN,
                    ROUND(AVG(PlayerStats.Points),1) AS PTS,
                    ROUND(AVG(PlayerStats.Rebounds),1) AS REB,
                    ROUND(AVG(PlayerStats.Assists),1) AS AST,
                    ROUND(AVG(PlayerStats.Blocks),1) AS BLK,
                    ROUND(AVG(PlayerStats.Steals),1) AS STL,
                    ROUND(AVG(PlayerStats.`FGMade`),1) AS `FGM`,
                    ROUND(AVG(PlayerStats.`FGAttempts`),1) AS `FGA`,
                    ROUND(((AVG(PlayerStats.FGMade) / AVG(PlayerStats.FGAttempts)) * 100),1) AS FGPCT,
                    ROUND(AVG(PlayerStats.`3PMade`),1) AS `3PM`,
                    ROUND(AVG(PlayerStats.`3PAttempts`),1) AS `3PA`,
                    ROUND(((AVG(PlayerStats.`3PMade`) / AVG(PlayerStats.`3PAttempts`)) * 100),1) AS 3PPCT,
                    ROUND(AVG(PlayerStats.`FTMade`),1) AS `FTM`,
                    ROUND(AVG(PlayerStats.`FTAttempts`),1) AS `FTA`,
                    ROUND(((AVG(PlayerStats.`FTMade`) / AVG(PlayerStats.`FTAttempts`)) * 100),0) AS FTPCT
                    From PlayerStats
                    LEFT JOIN Game On PlayerStats.GameID = Game.GameID
                    Left Join Season on Game.SeasonID = Season.SeasonID
                    LEFT JOIN Player ON PlayerStats.PlayerID = Player.PlayerID
                    LEFT JOIN PlayerYear on Player.PlayerID = PlayerYear.PlayerID and PlayerYear.SeasonID = Game.SeasonID
                    LEFT JOIN Class ON PlayerYear.ClassID = Class.ClassID
                    LEFT JOIN Team ON PlayerYear.TeamID = Team.TeamID
                    WHERE Player.PlayerID = %s
                    GROUP BY PlayerYear.PlayerID,
                    CASE WHEN Season.SeasonID < 10 
                    then concat(Team.Abbreviation, 0, Season.SeasonID, PlayerYear.PlayerID, '.jpg') 
                    else concat(Team.Abbreviation, Season.SeasonID, PlayerYear.PlayerID, '.jpg') end,
                    Season.Name,
                    Class.Abbreviation,
                    Team.Name,
                    Team.TeamID,
                    Team.Abbreviation,
                    PlayerYear.Position;'''


player_per30byyear = '''SELECT 
                    PlayerYear.PlayerID,
                    Season.Name Season,
                    Class.Abbreviation Year,
                    Team.Name Team,
                    Team.TeamID,
                    Team.Abbreviation,
                    PlayerYear.Position,
                    COUNT(DISTINCT PlayerStats.GameID) GP,
                    SUM(PlayerStats.Starter) GS,
                    ROUND(AVG(PlayerStats.Minutes),1) AS MIN,
                    ROUND(30/AVG(PlayerStats.Minutes) * AVG(PlayerStats.Points),1) AS PTS,
                    ROUND(30/AVG(PlayerStats.Minutes) * AVG(PlayerStats.Rebounds),1) AS REB,
                    ROUND(30/AVG(PlayerStats.Minutes) * AVG(PlayerStats.Assists),1) AS AST,
                    ROUND(30/AVG(PlayerStats.Minutes) * AVG(PlayerStats.Blocks),1) AS BLK,
                    ROUND(30/AVG(PlayerStats.Minutes) * AVG(PlayerStats.Steals),1) AS STL,
                    ROUND(30/AVG(PlayerStats.Minutes) * AVG(PlayerStats.FGMade),1) AS FGM,
                    ROUND(30/AVG(PlayerStats.Minutes) * AVG(PlayerStats.FGAttempts),1) AS FGA,
                    ROUND(((AVG(PlayerStats.FGMade) / AVG(PlayerStats.FGAttempts)) * 100),1) AS FGPCT,
                    ROUND(30/AVG(PlayerStats.Minutes) * AVG(PlayerStats.`3PMade`),1) AS 3PM,
                    ROUND(30/AVG(PlayerStats.Minutes) * AVG(PlayerStats.`3PAttempts`),1) AS 3PA,
                    ROUND(((AVG(PlayerStats.`3PMade`) / AVG(PlayerStats.`3PAttempts`)) * 100),1) AS 3PPCT,
                    ROUND(30/AVG(PlayerStats.Minutes) * AVG(PlayerStats.FTMade),1) AS FTM,
                    ROUND(30/AVG(PlayerStats.Minutes) * AVG(PlayerStats.FTAttempts),1) AS FTA,
                    ROUND(((AVG(PlayerStats.`FTMade`) / AVG(PlayerStats.`FTAttempts`)) * 100),0) AS FTPCT
                    From PlayerStats
                    LEFT JOIN Game On PlayerStats.GameID = Game.GameID
                    Left Join Season on Game.SeasonID = Season.SeasonID
                    LEFT JOIN Player ON PlayerStats.PlayerID = Player.PlayerID
                    LEFT JOIN PlayerYear on Player.PlayerID = PlayerYear.PlayerID and PlayerYear.SeasonID = Game.SeasonID
                    LEFT JOIN Class ON PlayerYear.ClassID = Class.ClassID
                    LEFT JOIN Team ON PlayerYear.TeamID = Team.TeamID
                    WHERE Player.PlayerID = %s
                    GROUP BY PlayerYear.PlayerID,
                    Season.Name,
                    Class.Abbreviation,
                    Team.Name,
                    Team.TeamID,
                    Team.Abbreviation,
                    PlayerYear.Position;'''


player_gamestatsbyseason = '''SELECT 
                            PlayerYear.PlayerID,
                            Season.Name seasonname,
                            Game.GameDate,
                            Game.GameID, 
                            CASE WHEN PlayerYear.TeamID = Game.AwayID and Game.Neutral = 0 THEN '@' ELSE '' END loc,
                            CASE WHEN PlayerYear.SeasonID = Season.SeasonID AND PlayerYear.TeamID = Game.HomeID THEN Away.Name
                            WHEN PlayerYear.SeasonID = Season.SeasonID AND PlayerYear.TeamID = Game.AwayID THEN Home.Name
                            ELSE '???' END Opponent,
                            CASE WHEN PlayerYear.SeasonID = Season.SeasonID AND PlayerYear.TeamID = Game.HomeID THEN Away.Abbreviation
                            WHEN PlayerYear.SeasonID = Season.SeasonID AND PlayerYear.TeamID = Game.AwayID THEN Home.Abbreviation
                            ELSE '???' END OppAbbr,
                            CASE WHEN PlayerYear.TeamID = Game.AwayID and Game.AwayPts > Game.HomePts THEN CONCAT('W, ', Game.AwayPts, '-', Game.HomePts)
                            WHEN PlayerYear.TeamID = Game.AwayID and Game.AwayPts < Game.HomePts THEN CONCAT('L, ', Game.HomePts, '-', Game.AwayPts)
                            WHEN PlayerYear.TeamID = Game.HomeID and Game.HomePts > Game.AwayPts THEN CONCAT('W, ', Game.HomePts, '-', Game.AwayPts)
                            WHEN PlayerYear.TeamID = Game.HomeID and Game.HomePts < Game.AwayPts THEN CONCAT('L, ', Game.AwayPts, '-', Game.HomePts)
                            ELSE '' END Result, 
                            CASE WHEN Starter = 1 then '*' ELSE '' END GS,
                            PlayerStats.Minutes MIN,
                            PlayerStats.Points PTS,
                            PlayerStats.Rebounds REB,
                            PlayerStats.Assists AST,
                            PlayerStats.Blocks BLK,
                            PlayerStats.Steals STL,
                            PlayerStats.FGMade FGM,
                            PlayerStats.FGAttempts FGA,
                            IFNULL(ROUND((PlayerStats.FGMade / PlayerStats.FGAttempts) * 100,1),0) AS FGPCT,
                            PlayerStats.`3PMade` AS `3PM`,
                            PlayerStats.`3PAttempts` AS `3PA`,
                            IFNULL(ROUND((PlayerStats.`3PMade` / PlayerStats.`3PAttempts`) * 100,1),0) AS 3PPCT,
                            PlayerStats.FTMade AS FTM,
                            PlayerStats.FTAttempts AS FTA,
                            IFNULL(ROUND((PlayerStats.`FTMade` / PlayerStats.`FTAttempts`) * 100,0),0) AS FTPCT
                            from PlayerStats 
                            LEFT JOIN Game On PlayerStats.GameID = Game.GameID
                            Left Join Season on Game.SeasonID = Season.SeasonID
                            LEFT JOIN Player ON PlayerStats.PlayerID = Player.PlayerID
                            LEFT JOIN PlayerYear on Player.PlayerID = PlayerYear.PlayerID and PlayerYear.SeasonID = Game.SeasonID
                            LEFT JOIN Class ON PlayerYear.ClassID = Class.ClassID
                            LEFT JOIN Team ON PlayerYear.TeamID = Team.TeamID
                            LEFT JOIN Team Home ON Game.HomeID = Home.TeamID
                            LEFT JOIN Team Away ON Game.AwayID = Away.TeamID
                            WHERE PlayerStats.PlayerID = %s
                            ORDER BY Game.GameDate'''


player_playerinfo = '''SELECT PlayerID, Name PlayerName, City PlayerCity, State PlayerState, PreviousSchool PrevSchool 
                        From Player where PlayerID = %s'''


team_roster = '''SELECT Player.PlayerID, Player.PlayerID pid, PlayerYear.Number PlayerNum, Player.Name PlayerName, PlayerYear.Height, PlayerYear.Position, Class.Abbreviation,
                CONCAT(Player.City, ', ', Player.State) Hometown, Player.PreviousSchool PrevSchool
                From Player 
                LEFT JOIN PlayerYear ON Player.PlayerID = PlayerYear.PlayerID
                LEFT JOIN Season on PlayerYear.SeasonID = Season.SeasonID
                LEFT JOIN Class ON PlayerYear.ClassID = Class.ClassID
                LEFT JOIN Team ON PlayerYear.TeamID = Team.TeamID
                where Team.Abbreviation = %s and Season.Name = %s
                and Player.Name != 'Team'
                order by PlayerYear.Number asc '''

team_playeraverages = '''SELECT a.*, b.* FROM (
                        SELECT Season.SeasonID, Season.Name SeasonName, Player.PlayerID pid, PlayerYear.Number PlayerNum, Player.Name PlayerName, 
                        PlayerYear.Height, PlayerYear.Position, Class.Abbreviation
                        From Player 
                        LEFT JOIN PlayerYear ON Player.PlayerID = PlayerYear.PlayerID
                        LEFT JOIN Season on PlayerYear.SeasonID = Season.SeasonID
                        LEFT JOIN Class ON PlayerYear.ClassID = Class.ClassID
                        LEFT JOIN Team on PlayerYear.TeamID = Team.TeamID
                        where Team.Abbreviation = %s and Season.Name = %s
                        and Player.Name != 'Team' ) a 
                        INNER JOIN (
                        SELECT 
                        PlayerYear.PlayerID,
                        Season.Name SeasonName,
                        Class.Abbreviation Year,
                        Team.Abbreviation Team,
                        PlayerYear.Position,
                        COUNT(DISTINCT PlayerStats.GameID) GP,
                        SUM(PlayerStats.Starter) GS,
                        ROUND(AVG(PlayerStats.Minutes),1) AS MIN,
                        ROUND(AVG(PlayerStats.Points),1) AS PTS,
                        ROUND(AVG(PlayerStats.Rebounds),1) AS REB,
                        ROUND(AVG(PlayerStats.Assists),1) AS AST,
                        ROUND(AVG(PlayerStats.Blocks),1) AS BLK,
                        ROUND(AVG(PlayerStats.Steals),1) AS STL,
                        ROUND(AVG(PlayerStats.Turnovers),1) AS TRN,
                        ROUND(AVG(PlayerStats.`FGMade`),1) AS `FGM`,
                        ROUND(AVG(PlayerStats.`FGAttempts`),1) AS `FGA`,
                        IFNULL(ROUND(((AVG(PlayerStats.FGMade) / AVG(PlayerStats.FGAttempts)) * 100),1),0) AS FGPCT,
                        ROUND(AVG(PlayerStats.`3PMade`),1) AS `3PM`,
                        ROUND(AVG(PlayerStats.`3PAttempts`),1) AS `3PA`,
                        IFNULL(ROUND(((AVG(PlayerStats.`3PMade`) / AVG(PlayerStats.`3PAttempts`)) * 100),1),0) AS 3PPCT,
                        ROUND(AVG(PlayerStats.`FTMade`),1) AS `FTM`,
                        ROUND(AVG(PlayerStats.`FTAttempts`),1) AS `FTA`,
                        IFNULL(ROUND(((AVG(PlayerStats.`FTMade`) / AVG(PlayerStats.`FTAttempts`)) * 100),0),0) AS FTPCT
                        From PlayerStats
                        LEFT JOIN Game On PlayerStats.GameID = Game.GameID
                        Left Join Season on Game.SeasonID = Season.SeasonID
                        LEFT JOIN Player ON PlayerStats.PlayerID = Player.PlayerID
                        LEFT JOIN PlayerYear on Player.PlayerID = PlayerYear.PlayerID and PlayerYear.SeasonID = Game.SeasonID
                        LEFT JOIN Class ON PlayerYear.ClassID = Class.ClassID
                        LEFT JOIN Team ON PlayerYear.TeamID = Team.TeamID
                        where Team.Abbreviation = %s and Season.Name = %s
                        GROUP BY PlayerYear.PlayerID,
                        Season.Name,
                        Class.Abbreviation,
                        Team.Abbreviation,
                        PlayerYear.Position) b
                        on a.pid = b.PlayerID and a.SeasonName = b.SeasonName
                        ORDER BY b.MIN desc, b.GP desc, b.GS desc;'''

team_gamelog = '''SELECT  
                Game.GameID, Game.GameID gid, Game.GameDate gdate, Season.Name seasonname,
                CASE 
                WHEN Game.Exhibition = 1 then '*'
                WHEN Team.TeamID = Game.AwayID and Game.Neutral = 0 THEN '@' 
                ELSE '' END loc,
                CASE WHEN Team.TeamID = Game.HomeID THEN Away.Name
                WHEN Team.TeamID = Game.AwayID THEN Home.Name
                ELSE '???' END Opponent,
                CASE WHEN Team.TeamID = Game.HomeID THEN Away.Abbreviation
                WHEN Team.TeamID = Game.AwayID THEN Home.Abbreviation
                ELSE '???' END OpponentAbbr,
                CASE WHEN Team.TeamID = Game.AwayID and Game.AwayPts > Game.HomePts THEN CONCAT('W, ', Game.AwayPts, '-', Game.HomePts)
                WHEN Team.TeamID = Game.AwayID and Game.AwayPts < Game.HomePts THEN CONCAT('L, ', Game.HomePts, '-', Game.AwayPts)
                WHEN Team.TeamID = Game.HomeID and Game.HomePts > Game.AwayPts THEN CONCAT('W, ', Game.HomePts, '-', Game.AwayPts)
                WHEN Team.TeamID = Game.HomeID and Game.HomePts < Game.AwayPts THEN CONCAT('L, ', Game.AwayPts, '-', Game.HomePts)
                ELSE '' END Result, 
                SUM(PlayerStats.Minutes) MIN,
                SUM(PlayerStats.Points) PTS,
                SUM(PlayerStats.Rebounds) REB,
                SUM(PlayerStats.Assists) AST,
                SUM(PlayerStats.Blocks) BLK,
                SUM(PlayerStats.Steals) STL,
                SUM(PlayerStats.Turnovers) TRN,
                SUM(PlayerStats.FGMade) FGM,
                SUM(PlayerStats.FGAttempts) FGA,
                IFNULL(ROUND((SUM(PlayerStats.FGMade) / SUM(PlayerStats.FGAttempts)) * 100,1),0) AS FGPCT,
                SUM(PlayerStats.`3PMade`) AS `3PM`,
                SUM(PlayerStats.`3PAttempts`) AS `3PA`,
                IFNULL(ROUND((SUM(PlayerStats.`3PMade`) / SUM(PlayerStats.`3PAttempts`)) * 100,1),0) AS 3PPCT,
                SUM(PlayerStats.FTMade) AS FTM,
                SUM(PlayerStats.FTAttempts) AS FTA,
                IFNULL(ROUND((SUM(PlayerStats.`FTMade`) / SUM(PlayerStats.`FTAttempts`)) * 100,0),0) AS FTPCT
                FROM PlayerStats
                LEFT JOIN Game On PlayerStats.GameID = Game.GameID
                Left Join Season on Game.SeasonID = Season.SeasonID
                LEFT JOIN Player ON PlayerStats.PlayerID = Player.PlayerID
                LEFT JOIN PlayerYear on Player.PlayerID = PlayerYear.PlayerID and PlayerYear.SeasonID = Game.SeasonID
                LEFT JOIN Class ON PlayerYear.ClassID = Class.ClassID
                LEFT JOIN Team ON PlayerYear.TeamID = Team.TeamID
                LEFT JOIN Team Home ON Game.HomeID = Home.TeamID
                LEFT JOIN Team Away ON Game.AwayID = Away.TeamID
                WHERE Team.Abbreviation = %s and Season.Name = %s
                GROUP BY Game.GameID, Game.GameID, Game.GameDate, Season.Name,
                CASE 
                WHEN Game.Exhibition = 1 then '*'
                WHEN Team.TeamID = Game.AwayID and Game.Neutral = 0 THEN '@' 
                ELSE '' END,
                CASE WHEN Team.TeamID = Game.HomeID THEN Away.Name
                WHEN Team.TeamID = Game.AwayID THEN Home.Name
                ELSE '???' END,
                CASE WHEN Team.TeamID = Game.HomeID THEN Away.Abbreviation
                WHEN Team.TeamID = Game.AwayID THEN Home.Abbreviation
                ELSE '???' END,
                CASE WHEN Team.TeamID = Game.AwayID and Game.AwayPts > Game.HomePts THEN CONCAT('W, ', Game.AwayPts, '-', Game.HomePts)
                WHEN Team.TeamID = Game.AwayID and Game.AwayPts < Game.HomePts THEN CONCAT('L, ', Game.HomePts, '-', Game.AwayPts)
                WHEN Team.TeamID = Game.HomeID and Game.HomePts > Game.AwayPts THEN CONCAT('W, ', Game.HomePts, '-', Game.AwayPts)
                WHEN Team.TeamID = Game.HomeID and Game.HomePts < Game.AwayPts THEN CONCAT('L, ', Game.AwayPts, '-', Game.HomePts)
                ELSE '' END
                order by GameDate asc'''


teamhome_teams = '''SELECT TeamID, TeamID tid, Name teamname, Abbreviation abbr, Mascot msct, City cty, State st, Division dvsn, Conference conf
                    From Team where Abbreviation IS NOT NULL ORDER BY conf, dvsn, teamname'''