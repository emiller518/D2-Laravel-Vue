import mysql.connector

dbconn = mysql.connector.connect(
        host="localhost", user="emiller", passwd="Soccer-479", database="hogswith_strosembb")


def teamindb(teamName, mydb=dbconn):
    mycursor = mydb.cursor()
    mycursor.execute('SELECT * from Team WHERE Name=%s', [teamName])
    myresult=mycursor.fetchall()
    if len(myresult) > 0:
        return True
    if len(myresult) == 0:
        return False
    
    
def playernumindb(teamID, num, season, mydb=dbconn):

    mycursor = mydb.cursor(buffered=True)

    mycursor.execute('SELECT Player.PlayerID FROM Player INNER JOIN PlayerYear '
                     'ON Player.PlayerID = PlayerYear.PlayerID INNER JOIN Season '
                     'ON Season.SeasonID = PlayerYear.SeasonID INNER JOIN Team '
                     'ON PlayerYear.TeamID = Team.TeamID WHERE Team.TeamID = %s '
                     'AND PlayerYear.Number = %s AND Season.Name = %s;', (teamID, num, season))
    myresult = mycursor.fetchone()
    if myresult is not None:
        return myresult[0]
    else:
        return None


def insertminplayeryear(playerID, teamID, season, number, mydb=dbconn):


    mycursor = mydb.cursor(buffered=True)

    mycursor.execute('SELECT Player.PlayerID FROM Player INNER JOIN PlayerYear '
                     'ON Player.PlayerID = PlayerYear.PlayerID INNER JOIN Season '
                     'ON Season.SeasonID = PlayerYear.SeasonID INNER JOIN Team '
                     'ON PlayerYear.TeamID = Team.TeamID WHERE Team.TeamID = %s '
                     'AND Season.Name = %s AND Player.PlayerID = %s;', (teamID, season, playerID))
    myresult = mycursor.fetchone()

    if myresult is None:

        seasonid = getseasonid(season)
        sql = "INSERT INTO PlayerYear (PlayerID, TeamID, SeasonID, ClassID, Number) VALUES (%s, %s, %s, 0, %s);"
        val = (playerID, teamID, seasonid, number)
        mycursor.execute(sql, val)
        mydb.commit()


def playernameindb(teamID, name, mydb=dbconn):

    mycursor = mydb.cursor(buffered=True)

    mycursor.execute('SELECT Player.PlayerID FROM Player INNER JOIN PlayerYear '
                     'ON Player.PlayerID = PlayerYear.PlayerID INNER JOIN Season '
                     'ON Season.SeasonID = PlayerYear.SeasonID INNER JOIN Team '
                     'ON PlayerYear.TeamID = Team.TeamID WHERE Team.TeamID = %s '
                     'AND Player.Name = %s;', (teamID, name))
    myresult = mycursor.fetchone()
    if myresult is not None:
        return myresult[0]
    else:
        return None


def getteamid(teamName, mydb=dbconn):

    mycursor = mydb.cursor(buffered=True)
    mycursor.execute('SELECT TeamID from Team WHERE Name=%s', [teamName])
    myresult=mycursor.fetchone()
    if myresult is not None:
        return myresult[0]
    else:
        return None


def getminplayeridpbp(gameid, mydb=dbconn):

    mycursor = mydb.cursor(buffered=True)
    mycursor.execute('SELECT min(PlayerID) From PlayByPlay WHERE GameID = %s', [gameid])
    myresult=mycursor.fetchone()
    if myresult is not None:
        return myresult[0]
    else:
        return None


def getteamidfromgame(gameID, team, mydb=dbconn):

    mycursor = mydb.cursor(buffered=True)
    if team == 'H':
        mycursor.execute('SELECT HomeID FROM Game WHERE GameID =%s', [gameID])
    else:
        mycursor.execute('SELECT AwayID FROM Game WHERE GameID =%s', [gameID])
    myresult=mycursor.fetchone()
    return myresult[0]


def getteamnamefromabbr(teamabbr, mydb=dbconn):

    mycursor = mydb.cursor(buffered=True)
    mycursor.execute('SELECT Name from Team WHERE Abbreviation=%s', [teamabbr])
    myresult=mycursor.fetchone()
    return myresult[0]


def getteamidfromabvr(abbreviation, mydb=dbconn):

    mycursor = mydb.cursor(buffered=True)
    mycursor.execute('SELECT TeamID from Team WHERE Abbreviation=%s', [abbreviation])
    myresult=mycursor.fetchone()
    return myresult[0]


def getplayerid(teamID, number, year, mydb=dbconn):

    mycursor = mydb.cursor(buffered=True)
    mycursor.execute('SELECT Player.PlayerID FROM Player INNER JOIN PlayerYear '
                     'ON Player.PlayerID = PlayerYear.PlayerID INNER JOIN Season '
                     'ON Season.SeasonID = PlayerYear.SeasonID INNER JOIN Team '
                     'ON PlayerYear.TeamID = Team.TeamID WHERE Team.TeamID = %s '
                     'AND PlayerYear.Number = %s AND Season.Name = %s;', (teamID, number, year))
    myresult=mycursor.fetchone()
    return myresult[0]


def getplayeridpbp(teamID, sqlname, year, mydb=dbconn):

    first = sqlname[0]
    last = sqlname[1]

    mycursor = mydb.cursor(buffered=True)
    mycursor.execute('SELECT Player.PlayerID From Player '
                     'INNER JOIN PlayerYear On Player.PlayerID = PlayerYear.PlayerID '
                     'INNER JOIN Season On Season.SeasonID = PlayerYear.SeasonID '
                     'where Player.Name LIKE %s AND Player.Name Like %s '
                     'AND Season.Name = %s  AND PlayerYear.TeamID = %s;', (first, last, year, teamID))
    firstlastresult=mycursor.fetchone()
    if firstlastresult is None:

        mycursor.execute('SELECT Player.PlayerID From Player '
                         'INNER JOIN PlayerYear On Player.PlayerID = PlayerYear.PlayerID '
                         'INNER JOIN Season On Season.SeasonID = PlayerYear.SeasonID '
                         'where Player.Name Like %s '
                         'AND Season.Name = %s  AND PlayerYear.TeamID = %s;', (last, year, teamID))
        lastonlyresult = mycursor.fetchone()

        if lastonlyresult is None:

            return None

        else:
            return lastonlyresult[0]

    else:
        return firstlastresult[0]


def getgameid(date, team1, team2, mydb=dbconn):

    mycursor = mydb.cursor(buffered=True)
    sql = "SELECT * FROM Game where GameDate = %s AND (HomeID = %s OR AwayID = %s) " \
          "AND (HomeID = %s OR AwayID = %s);"
    val = (date, team1, team1, team2, team2)
    mycursor.execute(sql, val)
    myresult=mycursor.fetchone()
    return myresult[0]


def getteamconf(teamName, mydb=dbconn):

    mycursor = mydb.cursor()
    mycursor.execute('SELECT Conference from Team WHERE Name=%s', [teamName])
    myresult=mycursor.fetchall()
    return myresult[0][0]


def getteamconffromabbr(teamabbr, mydb=dbconn):

    mycursor = mydb.cursor()
    mycursor.execute('SELECT Conference from Team WHERE Abbreviation=%s', [teamabbr])
    myresult=mycursor.fetchall()
    return myresult[0][0]


def getseasonid(season, mydb=dbconn):

    mycursor = mydb.cursor(buffered=True)
    mycursor.execute('SELECT SeasonID from Season WHERE Name=%s', [season])
    myresult=mycursor.fetchone()
    return myresult[0]


def getseasonidfromgameid(gameid, mydb=dbconn):

    mycursor = mydb.cursor(buffered=True)
    mycursor.execute('SELECT SeasonID from Game WHERE GameID=%s', [gameid])
    myresult=mycursor.fetchone()
    return myresult[0]



def insertplayer(playerName, number, teamid, season, mydb=dbconn):

    mycursor = mydb.cursor()
    seasonid = getseasonid(season)

    sql = "INSERT INTO Player (Name) VALUE (%s);"
    val = (playerName,)
    mycursor.execute(sql, val)

    sql = "INSERT INTO PlayerYear (PlayerID, TeamID, SeasonID, ClassID, Number) VALUES (LAST_INSERT_ID(), %s, %s, 0, %s);"
    val = (teamid, seasonid, number)
    mycursor.execute(sql, val)

    mydb.commit()


def insertteam(teamName, mydb=dbconn):

    mycursor = mydb.cursor()

    sql = "INSERT INTO Team (Name) VALUE (%s);"
    val = (teamName,)
    mycursor.execute(sql, val)
    mydb.commit()

    #query = """
    #INSERT INTO `Team` (Name, Abbreviation, College, Mascot, City, State, Division, Conference)
    #VALUES (%s, %s, %s, %s, %s, %s, %s, %s)
    #"""
    #mycursor.execute(query, (teamName, None, None, None, None, None, None, None))
    #mydb.commit()




def insertgame(statlist, mydb=dbconn):
    # Change gameID to be large int in the database, just to be safe

    mycursor = mydb.cursor()
    sql = "INSERT INTO Game VALUES (%s, %s, %s, %s, %s, %s, %s, %s, '%s', %s, %s, %s, %s, %s, %s, %s, %s, \'%s\');" % tuple(statlist)
    mycursor.execute(sql)
    mydb.commit()


def insertgamelegacy(statlist, mydb=dbconn):
    # Change gameID to be large int in the database, just to be safe

    mycursor = mydb.cursor()
    sql = "INSERT INTO Game VALUES (%s, %s, %s, %s, %s, %s, %s, %s, '%s', %s, %s, %s, %s, %s, %s, %s, %s, \'%s\');" % tuple(statlist)
    mycursor.execute(sql)
    mydb.commit()


def insertplayerstats(statlist, mydb=dbconn):
    mycursor = mydb.cursor()

    sql = "INSERT INTO PlayerStats (GameID, PlayerID, Minutes, FGMade, FGAttempts, `3PMade`, `3PAttempts`, FTMade, " \
          "FTAttempts, OffReb, DefReb, Rebounds, Assists, Steals, Blocks, Turnovers, Fouls, Points, Starter) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s" \
          ", %s, %s, %s, %s, %s, %s, %s, %s, %s );" % tuple(statlist)

    mycursor.execute(sql)
    mydb.commit()


def insertplayerstatslegacy(statlist, mydb=dbconn):
    mycursor = mydb.cursor()

    sql = "INSERT INTO PlayerStats (GameID, PlayerID, Starter, FGMade, FGAttempts, `3PMade`, `3PAttempts`, FTMade, " \
          "FTAttempts, OffReb, DefReb, Rebounds, Fouls, Points, Assists, Turnovers, Blocks, Steals, Minutes) " \
          "VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s" \
          ", %s, %s, %s, %s, %s, %s, %s, %s, %s );" % tuple(statlist)

    mycursor.execute(sql)
    mydb.commit()


def insertteamstats(statlist, mydb=dbconn):
    mycursor = mydb.cursor()

    sql = "INSERT INTO TeamStats VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"
    mycursor.execute(sql, tuple(statlist))
    mydb.commit()


def insertlink(gameid, linksegment, conf, mydb=dbconn):
    if conf == 'NE10':
        sourceid = 1
    elif conf == 'ECC':
        sourceid = 2
    elif conf == 'CACC':
        sourceid = 3

    mycursor = mydb.cursor()

    sql = "INSERT INTO GameSource VALUES ( %s, %s, %s, %s, %s, %s, %s );"
    val = (gameid, sourceid, linksegment, 0,0,0,0)
    mycursor.execute(sql, val)
    mydb.commit()


def insertpbp(plays, mydb=dbconn):
    mycursor = mydb.cursor()
    sql = 'INSERT INTO PlayByPlay (GameID, Half, PlayNum, Time, Seconds, PlayerID, PlayTypeID, HomeScore, AwayScore, Team, Name) ' \
          'VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s);'
    val = (plays[0], plays[1], plays[2], plays[3], plays[4], plays[5], plays[6], plays[7], plays[8], plays[9], plays[10])
    mycursor.execute(sql, val)
    mydb.commit()


def linkindb(link, mydb=dbconn):

    mycursor = mydb.cursor()
    mycursor.execute('SELECT * from GameSource Where LinkSegment =%s', [link])
    myresult = mycursor.fetchall()
    if len(myresult) > 0:
        return True
    if len(myresult) == 0:
        return False


def pbpindb(link, mydb=dbconn):

    mycursor = mydb.cursor()
    mycursor.execute('SELECT PBP from GameSource Where LinkSegment =%s', [link])
    myresult = mycursor.fetchall()
    return myresult[0][0]


def lineupindb(link, mydb=dbconn):

    mycursor = mydb.cursor()
    mycursor.execute('SELECT Lineup from GameSource Where LinkSegment =%s', [link])
    myresult = mycursor.fetchall()
    return myresult[0][0]



def getgameidfromlink(link, mydb=dbconn):

    mycursor = mydb.cursor()
    mycursor.execute('SELECT GameID from GameSource Where LinkSegment =%s', [link])
    myresult = mycursor.fetchall()
    return myresult[0][0]


def checkgameidlegacy(gameid, mydb=dbconn):

    mycursor = mydb.cursor()
    mycursor.execute('SELECT * from GameSource Where GameID =%s', [gameid])
    myresult = mycursor.fetchall()
    if len(myresult) > 0:
        return True
    if len(myresult) == 0:
        return False


def checkifteamplayedlegacy(gamedate, team, mydb=dbconn):
    ret = False

    mycursor = mydb.cursor()
    mycursor.execute('SELECT * From Game WHERE GameDate = %s AND HomeID = %s', (gamedate, team))
    myresult = mycursor.fetchall()
    if len(myresult) > 0:
        ret = True

    mycursor = mydb.cursor()
    mycursor.execute('SELECT * From Game WHERE GameDate = %s AND HomeID = %s', (gamedate, team))
    myresult = mycursor.fetchall()
    if len(myresult) > 0:
        ret = True

    return ret


def markpbpcomplete(linksegment, mydb=dbconn):
    mycursor = mydb.cursor()
    sql = "UPDATE GameSource SET PBP = 1 WHERE LinkSegment = %s;"
    val = (linksegment,)
    mycursor.execute(sql, val)
    mydb.commit()


def markpbperror(linksegment, mydb=dbconn):
    mycursor = mydb.cursor()
    sql = "UPDATE GameSource SET PBP = 2 WHERE LinkSegment = %s;"
    val = (linksegment,)
    mycursor.execute(sql, val)
    mydb.commit()



def marklineupcomplete(gameid, mydb=dbconn):
    mycursor = mydb.cursor()
    sql = "UPDATE GameSource SET Lineup = 1 WHERE GameID = %s;"
    val = (gameid,)
    mycursor.execute(sql, val)
    mydb.commit()


def marklineupincomplete(gameid, val, mydb=dbconn):
    mycursor = mydb.cursor()
    sql = "UPDATE GameSource SET Lineup = %s WHERE GameID = %s;"
    val = (val, gameid,)
    mycursor.execute(sql, val)
    mydb.commit()


# ################################################ #
#
#
#    SCOUTING REPORT FUNCTIONS
#
#
# ################################################ #


def getteamstats(teamabbr, season="2018-19", mydb=dbconn):

    seasonID = getseasonid(season)

    mycursor = mydb.cursor(buffered=True)
    mycursor.execute(
        'SELECT '
        'Team.TeamID,'
        'Team.Name,'
        'COUNT(DISTINCT PlayerStats.GameID) AS GP,'
        'ROUND((SUM(PlayerStats.Points) / COUNT(DISTINCT PlayerStats.GameID) ),1) AS PPG,'
        'ROUND((SUM(PlayerStats.FGMade) / COUNT(DISTINCT PlayerStats.GameID) ),1) AS FGM,'
        'ROUND((SUM(PlayerStats.FGAttempts) / COUNT(DISTINCT PlayerStats.GameID) ),1) AS FGA,'
        'ROUND(((SUM(PlayerStats.FGMade) / SUM(PlayerStats.FGAttempts)) * 100),0) AS FGPCT,'
        'ROUND((SUM(PlayerStats.`3PMade`) / COUNT(DISTINCT PlayerStats.GameID) ),1) AS `3PM`,'
        'ROUND((SUM(PlayerStats.`3PAttempts`) / COUNT(DISTINCT PlayerStats.GameID) ),1) AS `3PA`,'
        'ROUND(((SUM(PlayerStats.`3PMade`) / SUM(PlayerStats.`3PAttempts`)) * 100),0) AS `3PPCT`,'
        'ROUND((SUM(PlayerStats.`FTMade`) / COUNT(DISTINCT PlayerStats.GameID) ),1) AS FTM,'
        'ROUND((SUM(PlayerStats.`FTAttempts`) / COUNT(DISTINCT PlayerStats.GameID) ),1) AS FTA,'
        'ROUND(((SUM(PlayerStats.`FTMade`) / SUM(PlayerStats.`FTAttempts`)) * 100),0) AS `FTPCT`,'
        'ROUND((SUM(PlayerStats.`OffReb`) / COUNT(DISTINCT PlayerStats.GameID) ),1) AS OREB,'
        'ROUND((SUM(PlayerStats.`DefReb`) / COUNT(DISTINCT PlayerStats.GameID) ),1) AS DREB,'
        'ROUND((SUM(PlayerStats.`Rebounds`) / COUNT(DISTINCT PlayerStats.GameID) ),1) AS REB,'
        'ROUND((SUM(PlayerStats.`Assists`) / COUNT(DISTINCT PlayerStats.GameID) ),1) AS AST,'
        'ROUND((SUM(PlayerStats.`Steals`) / COUNT(DISTINCT PlayerStats.GameID) ),1) AS STL,'
        'ROUND((SUM(PlayerStats.`Blocks`) / COUNT(DISTINCT PlayerStats.GameID) ),1) AS BLK,'
        'ROUND((SUM(PlayerStats.`Turnovers`) / COUNT(DISTINCT PlayerStats.GameID) ),1) AS `TO`,'
        'SUM(PlayerStats.`3PMade`) as total3pm,'
        'SUM(PlayerStats.`3PAttempts`) as total3pa,'
        'SUM(PlayerStats.FGMade) as totalfgm,'
        'SUM(PlayerStats.FGAttempts) as totalfga '
        'From PlayerStats '
        'INNER JOIN Player on PlayerStats.PlayerID = Player.PlayerID '
        'INNER JOIN PlayerYear on Player.PlayerID = PlayerYear.PlayerID '
        'INNER JOIN Team on PlayerYear.TeamID = Team.TeamID '
        'INNER JOIN Game on Game.GameID = PlayerStats.GameID '
        'INNER JOIN Season on Game.SeasonID = Season.SeasonID '
        'WHERE '
        '(Team.Conference = "CACC" OR Team.Conference = "NE10" OR Team.Conference = "ECC") '
        'AND (Team.Abbreviation = %s) '
        'AND (Game.Exhibition = 0) '
        'AND (Season.SeasonID = %s) '
        'AND PlayerYear.SeasonID = %s '
        'Group By Team.TeamID', (teamabbr, seasonID, seasonID))

    myresult=mycursor.fetchone()
    return myresult


def getoppstats(teamabbr, season="2018-19", mydb=dbconn):

    teamID = getteamidfromabvr(teamabbr)
    seasonID = getseasonid(season)

    mycursor = mydb.cursor(buffered=True)
    mycursor.execute(
        'SELECT '
        'COUNT(DISTINCT PlayerStats.GameID) AS GP,'
        'ROUND((SUM(PlayerStats.Points) / COUNT(DISTINCT PlayerStats.GameID) ),1) AS PPG,'
        'ROUND((SUM(PlayerStats.FGMade) / COUNT(DISTINCT PlayerStats.GameID) ),1) AS FGM,'
        'ROUND((SUM(PlayerStats.FGAttempts) / COUNT(DISTINCT PlayerStats.GameID) ),1) AS FGA,'
        'ROUND(((SUM(PlayerStats.FGMade) / SUM(PlayerStats.FGAttempts)) * 100),0) AS FGPCT,'
        'ROUND((SUM(PlayerStats.`3PMade`) / COUNT(DISTINCT PlayerStats.GameID) ),1) AS `3PM`,'
        'ROUND((SUM(PlayerStats.`3PAttempts`) / COUNT(DISTINCT PlayerStats.GameID) ),1) AS `3PA`,'
        'ROUND(((SUM(PlayerStats.`3PMade`) / SUM(PlayerStats.`3PAttempts`)) * 100),0) AS `3PPCT`,'
        'ROUND((SUM(PlayerStats.`FTMade`) / COUNT(DISTINCT PlayerStats.GameID) ),1) AS FTM,'
        'ROUND((SUM(PlayerStats.`FTAttempts`) / COUNT(DISTINCT PlayerStats.GameID) ),1) AS FTA,'
        'ROUND(((SUM(PlayerStats.`FTMade`) / SUM(PlayerStats.`FTAttempts`)) * 100),0) AS `FTPCT`,'
        'ROUND((SUM(PlayerStats.`OffReb`) / COUNT(DISTINCT PlayerStats.GameID) ),1) AS OREB,'
        'ROUND((SUM(PlayerStats.`DefReb`) / COUNT(DISTINCT PlayerStats.GameID) ),1) AS DREB,'
        'ROUND((SUM(PlayerStats.`Rebounds`) / COUNT(DISTINCT PlayerStats.GameID) ),1) AS REB,'
        'ROUND((SUM(PlayerStats.`Assists`) / COUNT(DISTINCT PlayerStats.GameID) ),1) AS AST,'
        'ROUND((SUM(PlayerStats.`Steals`) / COUNT(DISTINCT PlayerStats.GameID) ),1) AS STL,'
        'ROUND((SUM(PlayerStats.`Blocks`) / COUNT(DISTINCT PlayerStats.GameID) ),1) AS BLK,'
        'ROUND((SUM(PlayerStats.`Turnovers`) / COUNT(DISTINCT PlayerStats.GameID) ),1) AS `TO`'
        'From Game '
        'INNER JOIN PlayerStats on PlayerStats.GameID = Game.GameID '
        'INNER JOIN PlayerYear on PlayerStats.PlayerID = PlayerYear.PlayerID '
        'INNER JOIN Team on PlayerYear.TeamID = Team.TeamID '
        'INNER JOIN Season on Game.SeasonID = Season.SeasonID '
        'WHERE (Game.HomeID = %s or Game.AwayID = %s) '
        'AND (Team.TeamID <> %s) '
        'AND (Season.SeasonID = %s) '
        'AND (PlayerYear.SeasonID = %s) '
        'AND (Game.Exhibition = 0);', (teamID, teamID, teamID, seasonID, seasonID))

    myresult = mycursor.fetchone()
    return myresult


def scoutplayer(teamabbr, season, playernum, paintm, painta, mydb=dbconn):
    mycursor = mydb.cursor(buffered=True)
    mycursor.execute(
        'SELECT '
        'c.Number AS `No`,'
        'b.Name,'
        'c.Position,'
        'c.Height,'
        'f.Abbreviation,'
        'ROUND(AVG(a.Points),1) AS PPG,'
        'ROUND(AVG(a.Rebounds),1) AS RPG,'
        'ROUND(AVG(a.Assists),1) AS APG,'
        'ROUND(AVG(a.Minutes),1) AS MPG,'
        'ROUND(((AVG(a.FGMade) / AVG(a.FGAttempts)) * 100),0) AS FGPCT,'
        'SUM(a.`FGMade`) AS `FGM`,'
        'SUM(a.`FGAttempts`) AS `FGA`,'
        'ROUND(((AVG(a.`3PMade`) / AVG(a.`3PAttempts`)) * 100),0) AS `3P%`,'
        'SUM(a.`3PMade`) AS `3PM`,'
        'SUM(a.`3PAttempts`) AS `3PA`,'
        'ROUND(((AVG(a.`FTMade`) / AVG(a.`FTAttempts`)) * 100),0) AS `FT%`,'
        'SUM(a.`FTMade`) AS `FTM`,'
        'SUM(a.`FTAttempts`) AS `FTA`,'
        'ROUND(AVG(a.FGMade),1) AS `FGM/G`,'
        'ROUND(AVG(a.FGAttempts),1) AS `FGA/G`,'
        'ROUND(AVG(a.`3PMade`),1) AS `3PM/G`,'
        'ROUND(AVG(a.`3PAttempts`),1) AS `3PA/G`,'
        'ROUND(AVG(a.FTMade),1) AS `FTM/G`,'
        'ROUND(AVG(a.FTAttempts),1) AS `FTA/G`'
        'FROM PlayerStats as a '
        'INNER JOIN Player as b ON a.PlayerID = b.PlayerID '
        'INNER JOIN PlayerYear as c ON a.PlayerID = c.PlayerID '
        'INNER JOIN Team as d ON c.TeamID = d.TeamID '
        'INNER JOIN Game as e ON a.GameID = e.GameID '
        'INNER JOIN Class as f on c.ClassID = f.ClassID '
        'INNER JOIN Season as g on g.SeasonID = e.SeasonID '
        'INNER JOIN Season as h on g.SeasonID = c.SeasonID '
        'WHERE d.Abbreviation = %s and c.Number = %s and e.Exhibition = 0 '
        'and g.Name = %s and h.Name = %s;', (teamabbr, playernum, season, season))

    myresult = mycursor.fetchone()

    if myresult[13] is None:
        myresult[13] = 0
    if myresult[16] is None:
        myresult[16] = 0

    fgm = int(myresult[10])
    fga = int(myresult[11])
    threem = int(myresult[13])
    threea = int(myresult[14])
    if painta == 0:
        paintpct = 0
    else:
        paintpct = round(paintm / painta *100)
    midm = fgm - threem - paintm
    mida = fga - threea - painta
    if mida == 0:
        midpct = 0
    else:
        midpct = round((midm/mida)*100)
    paintdist = round(painta/fga * 100)
    middist = round(mida/fga * 100)
    threedist = round(threea/fga * 100)

    photoid = str(teamabbr) + str(getseasonid(season)) + str(scoutplayerid(teamabbr, playernum, season))

    lst = list(myresult)
    if lst[9] is None:
        lst[9] = 0
    if lst[12] is None:
        lst[12] = 0
    if lst[15] is None:
        lst[15] = 0

    synergy = (paintpct, paintm, painta, midpct, midm, mida, paintdist, middist, threedist)
    final = (photoid,) + tuple(lst) + synergy
    return final


def scoutplayerid(teamabbr, number, season="2018-19", mydb=dbconn):

    mycursor = mydb.cursor(buffered=True)
    mycursor.execute('SELECT Player.PlayerID FROM Player INNER JOIN PlayerYear '
                     'ON Player.PlayerID = PlayerYear.PlayerID INNER JOIN Season '
                     'ON Season.SeasonID = PlayerYear.SeasonID INNER JOIN Team '
                     'ON PlayerYear.TeamID = Team.TeamID WHERE Team.Abbreviation = %s '
                     'AND PlayerYear.Number = %s AND Season.Name = %s;', (teamabbr, number, season))
    myresult=mycursor.fetchone()
    return myresult[0]


def headerinfo(teamabbr, season="2018-19", mydb=dbconn):
    seasonid = getseasonid(season)
    teamid = getteamidfromabvr(teamabbr)

    mycursor = mydb.cursor(buffered=True)
    mycursor.execute('SELECT COUNT(WinID) FROM Game WHERE WinID = %s AND SeasonID = %s;', (teamid, seasonid))
    totalwins = mycursor.fetchone()

    mycursor = mydb.cursor(buffered=True)
    mycursor.execute('SELECT COUNT(LossID) FROM Game WHERE LossID = %s AND SeasonID = %s;', (teamid, seasonid))
    totallosses = mycursor.fetchone()

    mycursor = mydb.cursor(buffered=True)
    mycursor.execute('SELECT COUNT(WinID) FROM Game WHERE WinID = %s AND NonLeague = 0 AND SeasonID = %s;', (teamid, seasonid))
    confwins = mycursor.fetchone()

    mycursor = mydb.cursor(buffered=True)
    mycursor.execute('SELECT COUNT(LossID) FROM Game WHERE LossID = %s AND NonLeague = 0 AND SeasonID = %s;',
                     (teamid, seasonid))
    conflosses = mycursor.fetchone()

    return totalwins + totallosses + confwins + conflosses


# ################################################ #
#
#
#    PLAYER SCRAPE FUNCTIONS
#
#
# ################################################ #


def playeronteamindb(teamID, name, mydb=dbconn):
    mycursor = mydb.cursor()
    mycursor.execute('SELECT Player.PlayerID FROM Player INNER JOIN PlayerYear '
                     'ON Player.PlayerID = PlayerYear.PlayerID INNER JOIN Team '
                     'ON PlayerYear.TeamID = Team.TeamID WHERE Team.TeamID = %s '
                     'AND Player.Name = %s;', (teamID, name))
    myresult = mycursor.fetchall()
    if len(myresult) > 0:
        return True
    if len(myresult) == 0:
        return False


def getplayernameid(teamID, name, mydb=dbconn):

    mycursor = mydb.cursor(buffered=True)
    mycursor.execute('SELECT Player.PlayerID FROM Player INNER JOIN PlayerYear '
                     'ON Player.PlayerID = PlayerYear.PlayerID INNER JOIN Team '
                     'ON PlayerYear.TeamID = Team.TeamID WHERE Team.TeamID = %s '
                     'AND Player.Name = %s;', (teamID, name))
    myresult=mycursor.fetchone()
    return myresult[0]


def playeryearindb(teamID, name, seasonID, mydb=dbconn):
    mycursor = mydb.cursor()
    mycursor.execute('SELECT Player.PlayerID FROM Player INNER JOIN PlayerYear '
                     'ON Player.PlayerID = PlayerYear.PlayerID INNER JOIN Team '
                     'ON PlayerYear.TeamID = Team.TeamID WHERE Team.TeamID = %s '
                     'AND Player.Name = %s AND PlayerYear.SeasonID = %s;', (teamID, name, seasonID))
    myresult = mycursor.fetchall()
    if len(myresult) > 0:
        return True
    if len(myresult) == 0:
        return False


def updateplayer(playerID, city, state, foreign, school, mydb=dbconn):
    mycursor = mydb.cursor()
    sql = "UPDATE Player SET City = %s, State = %s, `Foreign` = %s, PreviousSchool = %s WHERE PlayerID = %s;"
    val = (city, state, foreign, school, playerID)
    mycursor.execute(sql, val)
    mydb.commit()


def updateplayeryear(playerID, seasonID, classID, height, position, mydb=dbconn):
    mycursor = mydb.cursor()
    sql = "UPDATE PlayerYear SET ClassID = %s, Height = %s, Position = %s WHERE PlayerID = %s AND SeasonID = %s;"
    val = (classID, height, position, playerID, seasonID)
    mycursor.execute(sql, val)
    mydb.commit()


def insertplayeryear(playerID, teamID, seasonID, classID, number, height, position, mydb=dbconn):
    mycursor = mydb.cursor()
    sql = 'INSERT INTO PlayerYear (PlayerID, TeamID, SeasonID, ClassID, Number, Height, Position) ' \
          'VALUES (%s, %s, %s, %s, %s, %s, %s);'
    val = (playerID, teamID, seasonID, classID, number, height, position)
    mycursor.execute(sql, val)
    mydb.commit()


def insertplayerfull(player, playeryear, mydb=dbconn):
    mycursor = mydb.cursor()

    sql = "INSERT INTO Player (Name, City, State, `Foreign`, PreviousSchool) VALUES (%s, %s, %s, %s, %s);"
    val = (player[0], player[1], player[2], player[3], player[4])
    mycursor.execute(sql, val)

    sql = '''INSERT INTO PlayerYear (PlayerID, TeamID, SeasonID, ClassID, Number, Height, Position)
          VALUES (LAST_INSERT_ID(), %s, %s, %s, %s, %s, %s);'''
    val = (playeryear[0], playeryear[1], playeryear[2], playeryear[3], playeryear[4], playeryear[5])
    mycursor.execute(sql, val)
    mydb.commit()

def checkdupslegacy(teamid, mydb=dbconn):
    mycursor = mydb.cursor()

    mycursor.execute('SELECT '
                     'P.* From Player AS P '
                     'INNER JOIN PlayerYear AS PY On P.PlayerID = PY.PlayerID '
                     'join '
                     '(Select '
                     'Team.Name, '
                     'Player.PlayerID, '
                     'Player.Name AS NME, COUNT(Player.Name), '
                     'PlayerYear.SeasonID AS SID, COUNT(PlayerYear.SeasonID), '
                     'PlayerYear.Number AS NUM, COUNT(PlayerYear.Number) '
                     'From Player '
                     'INNER JOIN PlayerYear ON Player.PlayerID = PlayerYear.PlayerID '
                     'INNER JOIN Team ON PlayerYear.TeamID = Team.TeamID '
                     'WHERE PlayerYear.TeamID = %s '
                     'GROUP BY '
                     'Player.Name, '
                     'PlayerYear.SeasonID, '
                     'PlayerYear.Number '
                     'HAVING COUNT(Player.Name) > 1 '
                     'AND COUNT(PlayerYear.SeasonID) > 1 '
                     'AND COUNT(PlayerYear.Number) > 1) X '
                     'on '
                     'P.Name = X.NME '
                     'AND PY.Number = X.NUM '
                     'AND PY.SeasonID = X.SID;', (teamid,))
    myresult = mycursor.fetchall()

    my_dict = {}

    for i in (myresult):
        if i[1] == 'Team':
            pass
        else:
            if i[1] in my_dict:
                my_dict[i[1]].append(i[0])
            else:
                my_dict[i[1]] = [i[0]]

    for key in sorted(my_dict):
        print("#%s: %s" % (key, my_dict[key]))
        if len(my_dict[key]) == 2:
            print('CALL x5_updateplayer(' + str(my_dict[key][0]) + ', ' + str(my_dict[key][1]) + ');')
        elif len(my_dict[key]) == 3:
            print('CALL x5_updateplayer(' + str(my_dict[key][0]) + ', ' + str(my_dict[key][1]) + ');')
            print('CALL x5_updateplayer(' + str(my_dict[key][0]) + ', ' + str(my_dict[key][2]) + ');')
        elif len(my_dict[key]) == 4:
            print('CALL x5_updateplayer(' + str(my_dict[key][1]) + ', ' + str(my_dict[key][2]) + ');')
            print('CALL x5_updateplayer(' + str(my_dict[key][1]) + ', ' + str(my_dict[key][3]) + ');')
        else:
            print('CHECK')


def updatepbp(pbplist, seconds, homelineupid, awaylineupid, mydb=dbconn):
    mycursor = mydb.cursor()
    sql = "UPDATE PlayByPlay SET SecondsTaken = %s, HomeLineup = %s, AwayLineup = %s " \
          "WHERE GameID = %s and Half = %s and PlayNum = %s;"
    val = (seconds, homelineupid, awaylineupid, pbplist[0], pbplist[1], pbplist[2])
    mycursor.execute(sql, val)


def getpbp(gameID, mydb=dbconn):
    mycursor = mydb.cursor(buffered=True)
    mycursor.execute('SELECT a.*, b.Name From PlayByPlay a LEFT JOIN PBPPlayType b on a.PlayTypeID = b.PlayTypeID '
                     'where GameID = %s order by a.Half, a.PlayNum;', (gameID,))
    myresult = mycursor.fetchall()
    final_result = [list(i) for i in myresult]
    return (final_result)


def returnlineup(lineup, mydb=dbconn):
    # check if lineup already exists. if yes, return lineupid. if no, add to table.
    mycursor = mydb.cursor(buffered=True)
    mycursor.execute('select lineupid from Lineup where playerid in (%s,%s,%s,%s,%s) group by lineupid '
                     'having count(*) = 5', (lineup[0], lineup[1], lineup[2], lineup[3], lineup[4]))
    myresult = mycursor.fetchone()
    if myresult is not None:
        return (myresult[0])
    else:
        mycursor.execute('select max(lineupid) from Lineup')
        newlineupid = int(mycursor.fetchone()[0]) + 1

        for i in lineup:
            sql = "INSERT INTO Lineup VALUES (%s, %s);"
            val = (newlineupid, i)
            mycursor.execute(sql, val)

        return (newlineupid)


def gethomestarters(gameID, seasonID, mydb=dbconn):
    # print('1')
    mycursor = mydb.cursor(buffered=True)
    mycursor.execute('SELECT PlayerStats.PlayerID from PlayerStats '
                     'INNER JOIN Player ON Player.PlayerID = PlayerStats.PlayerID '
                     'INNER JOIN PlayerYear ON Player.PlayerID = PlayerYear.PlayerID '
                     'INNER JOIN Game ON PlayerStats.GameID = Game.GameID '
                     'where PlayerStats.GameID = %s '
                     'AND PlayerYear.SeasonID = %s '
                     'AND PlayerStats.Starter = 1 '
                     'AND PlayerYear.TeamID = Game.HomeID;', (gameID, seasonID))
    myresult = [item[0] for item in mycursor.fetchall()]
    return myresult


def getawaystarters(gameID, seasonID, mydb=dbconn):
    mycursor = mydb.cursor(buffered=True)
    mycursor.execute('SELECT PlayerStats.PlayerID from PlayerStats '
                     'INNER JOIN Player ON Player.PlayerID = PlayerStats.PlayerID '
                     'INNER JOIN PlayerYear ON Player.PlayerID = PlayerYear.PlayerID '
                     'INNER JOIN Game ON PlayerStats.GameID = Game.GameID '
                     'where PlayerStats.GameID = %s '
                     'AND PlayerYear.SeasonID = %s '
                     'AND PlayerStats.Starter = 1 '
                     'AND PlayerYear.TeamID = Game.AwayID;', (gameID, seasonID))
    myresult = [item[0] for item in mycursor.fetchall()]
    return myresult


def updateshotcoordinates(gameid, half, seconds, xsq, ysq, xrect, yrect, mydb=dbconn):

    mycursor = mydb.cursor(buffered=True)
    sql = "UPDATE PlayByPlay SET SquareX = %s, SquareY = %s, RectX = %s, RectY = %s " \
          "WHERE GameID = %s and Half = %s and Seconds = %s And PlayTypeID IN (4,5,6,7,8,9,10,11,12,13)"
    val = (xsq, ysq, xrect, yrect, gameid, half, seconds)
    mycursor.execute(sql, val)
    mydb.commit()


def updatepossession_all(gameid, mydb=dbconn):

    mycursor = mydb.cursor(buffered=True)
    sql = "UPDATE PlayByPlay SET Posession = 1 where PlayTypeID in (8,9,10,11,13,17,21) and GameID = %s"
    val = (gameid,)
    mycursor.execute(sql, val)
    mydb.commit()


def updatepossession_addlastft(gameid, mydb=dbconn):

    mycursor = mydb.cursor(buffered=True)
    sql = '''
    UPDATE PlayByPlay b
    INNER JOIN ( SELECT GameID, Half, Time, max(PlayNum) as playnum From PlayByPlay WHERE PlayTypeID IN (14,15) GROUP BY GameID, Half, Time ) a
    ON a.Half = b.Half and a.playnum = b.PlayNum and a.Time = b.Time and a.GameID = b.GameID
    SET Posession = 1
    WHERE b.PlayTypeID = 14 and b.GameID = %s
    '''
    val = (gameid,)
    mycursor.execute(sql, val)
    mydb.commit()


def updatepossession_rmand1(gameid, mydb=dbconn):

    mycursor = mydb.cursor(buffered=True)
    sql = "UPDATE PlayByPlay SET Posession = 0 WHERE PlayByPlayID in ( " \
          "SELECT pbp.* FROM ( " \
          "select PlayByPlayID from PlayByPlay " \
          "where(GameID, half, PlayNum , Seconds) IN " \
          "(SELECT GameID, half, PlayNum - 1 prevplay, Seconds " \
          "FROM PlayByPlay " \
          "WHERE PlayTypeID = 22 ) " \
          "AND GameID = %s " \
          "AND PlayTypeID in (8,9,10,11,13)) pbp )"
    val = (gameid,)
    mycursor.execute(sql, val)
    mydb.commit()


def getteamwebsite(gameid, mydb=dbconn):

    mycursor = mydb.cursor(buffered=True)
    sql = "SELECT Website From Team WHERE TeamID = (SELECT HomeID FROM Game WHERE GameID = %s )"
    val = (gameid,)
    mycursor.execute(sql, val)
    myresult = mycursor.fetchone()
    if myresult is not None:
        return myresult[0]
    else:
        return None

def getgamescore(gameid, mydb=dbconn):
    mycursor = mydb.cursor(buffered=True)
    sql = "SELECT HomePts, AwayPts FROM Game WHERE GameID = %s"
    val = (gameid,)
    mycursor.execute(sql, val)
    myresult = mycursor.fetchone()
    if myresult is not None:
        return myresult
    else:
        return None


def shotchartindb(link, mydb=dbconn):

    mycursor = mydb.cursor()
    sql = "SELECT ShotChart from GameSource Where LinkSegment =%s"
    val = (link,)
    mycursor.execute(sql, val)
    myresult = mycursor.fetchone()
    return myresult[0]


def markshotchartcomplete(gameid, mydb=dbconn):
    mycursor = mydb.cursor()
    sql = "UPDATE GameSource SET ShotChart = 1 WHERE GameID = %s;"
    val = (gameid,)
    mycursor.execute(sql, val)
    mydb.commit()


def possindb(link, mydb=dbconn):

    mycursor = mydb.cursor()
    sql = "SELECT Poss from GameSource Where LinkSegment =%s"
    val = (link,)
    mycursor.execute(sql, val)
    myresult = mycursor.fetchone()
    return myresult[0]


def markposscomplete(gameid, mydb=dbconn):
    mycursor = mydb.cursor()
    sql = "UPDATE GameSource SET Poss = 1 WHERE GameID = %s;"
    val = (gameid,)
    mycursor.execute(sql, val)
    mydb.commit()




