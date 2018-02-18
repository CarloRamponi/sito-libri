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

        .center {
            width: fit-content;
            float: none;
            margin-left: auto;
            margin-right: auto;
        }

        .paginationIcon {
            line-height: 1.5;
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

                    <div class="table-responsive">
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
                    </div>

                    <?php

                    //vedo quanti libri ci sono nel database per calcolare quanti bottoni creare

                    $libriPerPagina = 3;

                    $ris = $conn->query("SELECT * FROM libri;");
                    $numLibri = $ris->num_rows;

                    ?>

                    <div class="text-center">

                        <?php
                        if($numLibri > 0) {
                            ?>

                            <div class="center">
                                <ul class="pagination pagination-lg">
                                    <li id="paginationFirst" class="page-item disabled">
                                        <a class="page-link" onclick="pagination(-1)"><i class="fas fa-angle-double-left paginationIcon"></i></a>
                                    </li>
                                    <li id="paginationPrev" class="page-item disabled">
                                        <a class="page-link" onclick="pagination(-3)"><i class="fas fa-angle-left paginationIcon"></i></a>
                                    </li>
                                    <?php
                                    for($i=0; $i<$numLibri/$libriPerPagina; $i++) {
                                        ?>
                                        <li id="pagination<?php echo $i; ?>" class="page-item <?php echo ($i==0)? "active": "" ?>">
                                            <a class="page-link" onclick="pagination(<?php echo $i; ?>)"><?php echo $i+1; ?></a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                    <li id="paginationNext" class="page-item">
                                        <a class="page-link" onclick="pagination(-4)"><i class="fas fa-angle-right paginationIcon"></i></a>
                                    </li>
                                    <li id="paginationLast" class="page-item">
                                        <a class="page-link" onclick="pagination(-2)"><i class="fas fa-angle-double-right paginationIcon"></i></a>
                                    </li>
                                </ul>
                            </div>

                            <br>

                            <?php
                        }
                        ?>

                        <a href="aggiungiLibro.php" class="btn btn-success center">Aggiungi libro</a>

                    </div>

                    <br><br><br><br><br>

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

        url += "&from="+(page*libriPerPagina);
        url += "&numberOfRows="+libriPerPagina;

        xmlhttp.open("GET", url);
        xmlhttp.send();

    }

    var sort = 0;
    var asc = true;
    var ascIcon = "fa-sort-alpha-down";
    var descIcon = "fa-sort-alpha-up";

    var searchStr="";

    var libriPerPagina=<?php echo $libriPerPagina; ?>;
    var numPagine = <?php echo ($numLibri%$libriPerPagina == 0)? ($numLibri/$libriPerPagina)-1 : (int)($numLibri/$libriPerPagina) ; ?>;
    var page=0;

    function pagination(index) {

        if(page !== index){

            if(index < 0) { //se è stato clieccato il first o il last

                switch (index){
                    case -1:
                        page = 0;
                        break;

                    case -2:
                        page = numPagine;
                        break;

                    case -3:
                        page -= 1;
                        break;

                    case -4:
                        page += 1;
                        break;

                    default:
                        break;
                }

            } else {

                page = index;

            }

            getBooks();

            //abilito il nuovo elemento e controllo se è all'inizio o alla fine
            if(page === 0){
                $("#paginationFirst").addClass("disabled");
                $("#paginationPrev").addClass("disabled");
            } else {
                $("#paginationFirst").removeClass("disabled");
                $("#paginationPrev").removeClass("disabled");
            }

            if(page === numPagine){
                $("#paginationLast").addClass("disabled");
                $("#paginationNext").addClass("disabled");
            } else {
                $("#paginationLast").removeClass("disabled");
                $("#paginationNext").removeClass("disabled");
            }

            for(var i = 0; i <= numPagine; i++) {

                elem = $("#pagination"+i);

                if(i === page){
                    elem.addClass("active");
                } else {
                    elem.removeClass("active");
                }

            }

        }

    }

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

        pagination(0);
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

        pagination(0);
        searchStr = this.value;
        getBooks();

    });

    $("#badge").click( function () {

        var src = $("#searchBar");
        var badge = $("#badge");

        src.val("");
        badge.hide();

        searchStr = "";
        pagination(0);
        getBooks();

    } );

    getBooks();
    updateSorting();

</script>

</html>