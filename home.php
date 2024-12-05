<?php

include "jwt_helper.php";
include "Database/db_connection.php";

$db = connectDatabase();

$query = "SELECT  votes.nominee, votes.timestamp, votes.category, votes.voter, employees.name || ' ' || employees.surname AS voter_fullname FROM votes INNER JOIN employees ON votes.voter = employees.id";
$result = $db->query($query);


$byCategoryQuery = "
SELECT
    category,
    nominee,
    vote_count
FROM (
    SELECT
        category,
        nominee,
        COUNT(*) AS vote_count
    FROM
        votes

    GROUP BY
        category, nominee

) AS grouped_votes
WHERE vote_count = (
    SELECT MAX(vote_count)
    FROM (
        SELECT
            COUNT(*) AS vote_count
        FROM
            votes
        WHERE
            category = grouped_votes.category
        GROUP BY
            nominee
    ) AS max_votes

)

ORDER BY
    category, vote_count DESC;

";

//$byCategoryQuery = "
//SELECT
//    grouped_votes.category,
//    grouped_votes.nominee,
//    grouped_votes.vote_count,
//    most_voted_voter.voter_id,
//    most_voted_voter.vote_count AS voter_vote_count
//FROM (
//    SELECT
//        category,
//        nominee,
//        COUNT(*) AS vote_count
//    FROM
//        votes
//    GROUP BY
//        category, nominee
//) AS grouped_votes
//LEFT JOIN (
//    SELECT
//        category,
//        voter AS voter_id,
//        COUNT(*) AS vote_count
//    FROM
//        votes
//    GROUP BY
//        category, voter
//
//    ORDER BY
//        vote_count DESC
//    Limit 3
//
//) AS most_voted_voter
//ON grouped_votes.category = most_voted_voter.category
//WHERE grouped_votes.vote_count = (
//    SELECT MAX(vote_count)
//    FROM (
//        SELECT
//            COUNT(*) AS vote_count
//        FROM
//            votes
//        WHERE
//            category = grouped_votes.category
//        GROUP BY
//            nominee
//
//    ) AS max_votes
//)
//ORDER BY
//    grouped_votes.category, grouped_votes.vote_count DESC;
//";

$byCategoryResult = $db->query($byCategoryQuery);


session_start();
?>
<style>
    body {
        background-color: antiquewhite;
    }
    header, #categoryContainer {
        background-color: blanchedalmond;
        display: flex;
        flex-wrap: wrap;
        padding-left: 10px;
        padding-right: 10px;
        justify-content: space-between;
        align-items: center;
        border-radius: 5px;
        border: 5px solid white;
    }


    #auth {
        display: flex;
        gap: 15px; /* Space between the forms */
    }

    .button {
        padding: 15px;
        background-color: #444;
        color: white;
        border: none;
        cursor: pointer;
    }

    .button:hover {
        background-color: #555;
        border: 2px solid white;
    }

    #homeBody {
        display: flex;
        padding-left: 10px;
        padding-right: 10px;
        margin-top: 10px;
        justify-content: space-between;
        align-items: center;
        border-radius: 5px;
        border: 5px solid white;
    }
    #homeBody div {
        margin: 10px;
    }

    .categoryNominees{
        border: 5px solid white;
        border-radius: 5px;
        width: 280px;
        padding: 15px;
    }
</style>

<body>
<header>
    <h2>Home page</h2>
    <div id="auth">
        <?php if(!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])){ ?>
        <form action="Pages/auth/login.php" method="get" style="display: inline">
            <button class="button" type="submit">Login</button>
        </form>
        <form action="Pages/auth/register.php" method="get" style="display: inline">
            <button class="button" type="submit">Register</button>
        </form>
        <?php } else{ ?>
        <form action="Actions/auth/logout_handler.php" method="post" style="display: inline">
            <button class="button" type="submit">Logout</button>
        </form>
        <?php }?>
    </div>
</header>

<div id="homeBody">
    <div id="categoryContainer">
        <?php while ($roww = $byCategoryResult->fetchArray(SQLITE3_ASSOC)){?>
            <div class="categoryNominees">
                <h3>
                    Category:
                    <?php echo htmlspecialchars($roww['category']) ?>
                </h3>
                <hr>
                <br>
                <span>Nominee: <?php echo htmlspecialchars($roww['nominee']) ?></span>
                <br><br>
                <span>Votes: <?php echo htmlspecialchars($roww['vote_count']) ?></span>
                <br><br>
            </div>

        <?php }?>


    </div>

    <div>
        <?php if(isset($_SESSION['jwt']) && decodeJWT($_SESSION['jwt'])){ ?>
        <form action="Pages/vote.php" method="get" style="display: inline">
            <button class="button" type="submit">Vote</button>
        </form>
        <?php }?>
    </div>
</div>
</body>
