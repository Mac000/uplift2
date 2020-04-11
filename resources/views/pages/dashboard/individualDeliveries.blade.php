@extends('components.master')

@include('components.dashboard.bulma_nav')

<h3 id="cardHeader" class="card-header mb-2">Individual Deliveries</h3>
<div class="row">
    <div class="col pl-1 pr-1">
        <form class="mb-1" onsubmit="search()">
            <div class="input-group">
                <input id="name" type="text" class="form-control" placeholder="Search by Receiver Name">
                <div class="input-group-append">
                    <button class="btn btn-success" type="submit">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="tableContainer" class="row ml-3 d-none">
    <div id="table" class="table-responsive-lg ml-1">
        <table class="table table-hover">
            <thead id="insertAfterMe" class="thead-light">
            <tr>
                <th>Receiver</th>
                <th>#Phone</th>
                <th>Address</th>
                <th>GPS</th>
                <th>Tehsil</th>
                <th>items/Goods</th>
                <th>cost</th>
                <th>Delivered at</th>
                <th>Delivered By</th>
                <th>Evidence</th>
                <th>Help?</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<script>
    function search() {
        var input = document.getElementById("name").value;
        event.preventDefault();
        $.post("/dashboard/view-individual-deliveries", {
                name: input,
            },
            function (data, status) {
                var table_container = document.getElementById("tableContainer");
                table_container.classList.remove("d-none");
                var insertAfterMe = document.getElementById("insertAfterMe");

                if (!Array.isArray(data) || !data.length) {
                    let card_header = document.getElementById("cardHeader");

                    card_header.insertAdjacentHTML("beforebegin",
                        "<div id=\"alert\" class=\"notification is-warning cs-alert\">" +
                        "<button class=\"delete\" onclick=\"hideAlert()\"></button>" +
                        "<span>Record Not found</span>" +
                        "</div>");
                }

                for (response_data of data) {
                    /*
                     *  Looping over response collection and destructuring into multiple variable which are needed
                     */
                    var { receiver, user , goods, cost, created_at, image } = response_data;
                    var tr = document.createElement("tr");

                    //  Filling in Receiver Data
                    for (i in receiver) {

                        if (i === 'id' || i === 'needs') {
                            continue;
                        }
                        let td = document.createElement("td");
                            td.innerHTML = receiver[i];
                            tr.appendChild(td);
                    }
                    //  Goods
                    let td = document.createElement("td");
                    td.innerHTML = goods;
                    tr.appendChild(td);

                    //  Cost
                    td = document.createElement("td");
                    td.innerHTML = cost;
                    tr.appendChild(td);

                    //  Delivered at
                    td = document.createElement("td");
                    let formatted_date = moment(created_at).format('MMMM Do YYYY, h:mm:ss a');
                    td.innerHTML = formatted_date;
                    tr.appendChild(td);

                    //  Delivered By
                    for (i in user) {
                        if (i === 'id') {
                            continue;
                        }
                        let td = document.createElement("td");
                        td.innerHTML = user[i];
                        tr.appendChild(td);
                    }

                    //  Evidence
                    td = document.createElement("td");
                    let a = document.createElement("a");
                    // Change href for production environment
                    a.classList.add('btn', 'btn-primary');
                    a.href = "http://127.0.0.1:8000/" + image;
                    a.innerHTML = "View";
                    td.appendChild(a);
                    tr.appendChild(td);

                    //  Check Help
                    let help_td = document.createElement("td");
                    let help_a = document.createElement("a");
                    help_a.classList.add('btn', 'btn-danger');
                    help_a.href = "/dashboard/needs-help/receiver="+receiver.id+"&ph_no="+receiver.phone_no;
                    help_a.innerHTML = "check";
                    help_td.appendChild(help_a);
                    tr.appendChild(help_td);

                    insertAfterMe.appendChild(tr);
                }
            }).then(function () {
            //    This to change navigation height to compensate for lack of pagination
            let table_height = document.getElementById("table").clientHeight + 150;
            let nav = document.getElementById("navContainer");

            if (table_height > 1000 ) {
                nav.style.height = table_height;
            }
            else {
                nav.style.height = "140vh";
            }
        })
    }
    function hideAlert() {
        document.getElementById("alert").classList.add("d-none");
    }
</script>