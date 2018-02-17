<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 10/02/18
 * Time: 23.09
 */

include_once "connessione.php";
include_once "checkLogin.php";

$user = checkLogin($conn);

?>


<html>

<head>
    <title>BooksReviews - Libri</title>

    <?php include_once "includes.html"; ?>

    <style>
        .myCell{
            min-width: 150px;
        }
    </style>

</head>

    <body>

        <?php
            $pageNum = 1;
            include "navbar.php";
        ?>

        <div class="container">

            <br><br><br><br><br><br>

            <div class="row">

                <input class="form-control col-sm-12" type="text" placeholder="Cerca" id="searchBar">

            </div>

            <br><br>

            <a class="badge badge-pill badge-danger" style="display: none;" id="badge">
                <span id="badgeText"></span> <i class="fas fa-times-circle"></i></a>

            <br><br>

            <div class="row">
                <div class="col-sm-12">

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="myCell"><button onclick="changeSorting(0)" class="btn btn-link">ISBN</button> <i id="span0"></i></th>
                                <th class="myCell"><button onclick="changeSorting(1)" class="btn btn-link">Titolo</button> <i id="span1"></i></th>
                                <th class="myCell"><button onclick="changeSorting(2)" class="btn btn-link">Autore</button> <i id="span2"></i></th>
                                <th class="myCell"><button onclick="changeSorting(3)" class="btn btn-link">Anno</button> <i id="span3"></i></th>
                                <th class="myCell"><button onclick="changeSorting(4)" class="btn btn-link">Genere</button> <i id="span4"></i></th>
                                <th class="myCell"><button onclick="changeSorting(5)" class="btn btn-link">Voto</button> <i id="span5"></i></th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                        </tbody>
                    </table>

                    <a href="aggiungiLibro.php" class="btn btn-success">Aggiungi libro</a>

                </div>
            </div>

        </div>

    </body>

<script>

    function getBooks() {

        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function (ev) {
            if(this.readyState === 4 && this.status === 200) {
                var response = JSON.parse(this.responseText);
                if(response['request'] === 'getLibri'){
                    if(response['response'] === "noElements"){
                        $("#tbody").html("<tr><td colspan=5>Nessun libro corrisponde ai criteri di ricerca</td></tr>");
                    } else {

                        var html = "";

                        for(var i = 0; i < response['length']; i++){
                            html += "<tr>";

                            //ISBN:
                            html += "<td><a href='libro.php?isbn="+ response['response'][i][0] +"'>";
                            html += response['response'][i][0];
                            html += "</a></td>";

                            for(var j = 1; j < 5 ; j++){
                                html += "<td>";
                                html += response['response'][i][j];
                                html += "</td>";
                            }

                            //voto
                            html += "<td>";
                            if(response['response'][i][5] !== null) {

                                num = parseFloat(response['response'][i][5]);
                                num = Math.round( num * 2 ) / 2; //lo arrotondo

                                for(var k=0; k < Math.floor(num) ; k++){
                                    html += '<i class="fas fa-star"></i>';
                                }
                                if( num - Math.round( num ) !== 0) { //vedo se c'è un 0.5
                                    html += '<i class="fas fa-star-half"></i>';
                                }

                            }
                            html += "</td>";


                            html += "</tr>";
                        }

                        $("#tbody").html(html);

                    }
                }
            }

        };

        var url = "api.php?req=getLibri";

        if(sort !== -1) {
            url += "&orderBy=" + (sort+1) + "&asc="+( (asc) ? "true" : "false" );
        }

        if(searchStr !== ""){
            url += "&searchStr="+searchStr;
        }

        xmlhttp.open("GET", url);
        xmlhttp.send();

    }

    var sort = 0;
    var asc = true;
    var ascIcon = "fa-sort-alpha-down";
    var descIcon = "fa-sort-alpha-up";

    var searchStr="";

    function updateSorting() {

        for(var i = 0; i < 6; i++ ){

            var val = $("#span"+i);

            if(i === sort){
                if( asc ) {
                    val.addClass("fas").removeClass(descIcon).addClass(ascIcon);
                } else {
                    val.addClass("fas").removeClass(ascIcon).addClass(descIcon);
                }
            } else {
                val.removeClass("fas").removeClass(ascIcon).removeClass(descIcon);
            }

        }

    }

    function changeSorting(index) {

        if(index === sort)
            asc = !asc;
        else {
            sort = index;
            asc = true;
        }

        updateSorting();
        getBooks();

    }

    $("#searchBar").keyup(function () {

        var elem = $("#searchBar");
        var badge = $("#badge");
        var badgeText = $("#badgeText");

        if(elem.val() === "") {
            badge.hide();
        } else {
            badgeText.text( elem.val() );
            badge.show();
        }

        searchStr = this.value;
        getBooks();

    });

    $("#badge").click( function () {

        var src = $("#searchBar");
        var badge = $("#badge");

        src.val("");
        badge.hide();

        searchStr = "";
        getBooks();

    } );

    getBooks();
    updateSorting();

</script>

</html>