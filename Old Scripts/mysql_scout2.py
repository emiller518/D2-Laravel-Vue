import mysql.connector
from django.db import connection

def getseasonid(season):
    with connection.cursor() as mycursor:
        mycursor.execute('SELECT SeasonID from Season WHERE Name=%s', [season])
        myresult=mycursor.fetchone()
        mycursor.close()
    return myresult[0]


def getteamstats(teamabbr, season="2019-20"):

    seasonID = getseasonid(season)

    with connection.cursor() as mycursor:
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
        mycursor.close()
    return myresult


def getoppstats(teamabbr, season="2019-20"):

    teamID = getteamidfromabvr(teamabbr)
    seasonID = getseasonid(season)

    with connection.cursor() as mycursor:
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
        mycursor.close()
    return myresult


def scoutplayer(teamabbr, season, playernum, paintm, painta):
    with connection.cursor() as mycursor:

        sql = '''SELECT 
                c.Number AS 'No',
                b.Name,
                c.Position,
                c.Height,
                f.Abbreviation,
                ROUND(AVG(a.Points),1) AS PPG,
                ROUND(AVG(a.Rebounds),1) AS RPG,
                ROUND(AVG(a.Assists),1) AS APG,
                ROUND(AVG(a.Minutes),1) AS MPG,
                ROUND(((AVG(a.FGMade) / AVG(a.FGAttempts)) * 100),0) AS FGPCT,
                SUM(a.FGMade) AS FGM,
                SUM(a.FGAttempts) AS FGA,
                ROUND(((AVG(a.`3PMade`) / AVG(a.`3PAttempts`)) * 100),0) AS Threepct,
                SUM(a.`3PMade`) AS Threepm,
                SUM(a.`3PAttempts`) AS Threepa,
                ROUND(((AVG(a.FTMade) / AVG(a.FTAttempts)) * 100),0) AS FTPCT,
                SUM(a.FTMade) AS FTM,
                SUM(a.FTAttempts) AS FTA,
                ROUND(AVG(a.FGMade),1) AS FGMG,
                ROUND(AVG(a.FGAttempts),1) AS FGAG,
                ROUND(AVG(a.`3PMade`),1) AS THREEMG,
                ROUND(AVG(a.`3PAttempts`),1) AS THREEAG,
                ROUND(AVG(a.FTMade),1) AS FTMG,
                ROUND(AVG(a.FTAttempts),1) AS FTAG
                FROM PlayerStats as a 
                INNER JOIN Player as b ON a.PlayerID = b.PlayerID 
                INNER JOIN PlayerYear as c ON a.PlayerID = c.PlayerID 
                INNER JOIN Team as d ON c.TeamID = d.TeamID 
                INNER JOIN Game as e ON a.GameID = e.GameID 
                INNER JOIN Class as f on c.ClassID = f.ClassID 
                INNER JOIN Season as g on g.SeasonID = e.SeasonID 
                INNER JOIN Season as h on g.SeasonID = c.SeasonID 
                WHERE d.Abbreviation = %s and c.Number = %s and e.Exhibition = 0 
                and g.Name = %s and h.Name = %s
                GROUP BY c.Number, b.Name, c.Position, c.Height, f.Abbreviation;'''

        val = (teamabbr, playernum, season, season)

        mycursor.execute(sql, val)
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
        mycursor.close()
    return final


def scoutplayerid(teamabbr, number, season="2019-20"):
    with connection.cursor() as mycursor:
        mycursor.execute('SELECT Player.PlayerID FROM Player INNER JOIN PlayerYear '
                         'ON Player.PlayerID = PlayerYear.PlayerID INNER JOIN Season '
                         'ON Season.SeasonID = PlayerYear.SeasonID INNER JOIN Team '
                         'ON PlayerYear.TeamID = Team.TeamID WHERE Team.Abbreviation = %s '
                         'AND PlayerYear.Number = %s AND Season.Name = %s;', (teamabbr, number, season))
        myresult=mycursor.fetchone()
        mycursor.close()
    return myresult[0]


def headerinfo(teamabbr, season="2019-20"):
    seasonid = getseasonid(season)
    teamid = getteamidfromabvr(teamabbr)

    with connection.cursor() as mycursor:
        mycursor.execute('SELECT COUNT(WinID) FROM Game WHERE WinID = %s AND SeasonID = %s;', (teamid, seasonid))
        totalwins = mycursor.fetchone()

    with connection.cursor() as mycursor:
        mycursor.execute('SELECT COUNT(LossID) FROM Game WHERE LossID = %s AND SeasonID = %s;', (teamid, seasonid))
        totallosses = mycursor.fetchone()

    with connection.cursor() as mycursor:
        mycursor.execute('SELECT COUNT(WinID) FROM Game WHERE WinID = %s AND NonLeague = 0 AND SeasonID = %s;', (teamid, seasonid))
        confwins = mycursor.fetchone()

    with connection.cursor() as mycursor:
        mycursor.execute('SELECT COUNT(LossID) FROM Game WHERE LossID = %s AND NonLeague = 0 AND SeasonID = %s;',
                         (teamid, seasonid))
        conflosses = mycursor.fetchone()

    mycursor.close()

    return totalwins + totallosses + confwins + conflosses


def getteamnamefromabbr(teamabbr):
    with connection.cursor() as mycursor:
        mycursor.execute('SELECT Name from Team WHERE Abbreviation=%s', [teamabbr])
        myresult=mycursor.fetchone()
        mycursor.close()
    return myresult[0]


def getteamidfromabvr(abbreviation):
    with connection.cursor() as mycursor:
        mycursor.execute('SELECT TeamID from Team WHERE Abbreviation=%s', [abbreviation])
        myresult=mycursor.fetchone()
        mycursor.close()
    return myresult[0]


def getteamconffromabbr(teamabbr):
    with connection.cursor() as mycursor:
        mycursor.execute('SELECT Conference from Team WHERE Abbreviation=%s', [teamabbr])
        myresult=mycursor.fetchall()
        mycursor.close()
    return myresult[0][0]


