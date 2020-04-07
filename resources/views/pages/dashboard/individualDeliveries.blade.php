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
                <th>items/Goods</th>
                <th>cost</th>
                <th>Tehsil</th>
                <th>Delivered at</th>
                <th>Delivered By</th>
                <th>Evidence</th>
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
                for (receiver of data) {
                    var tr = document.createElement("tr");
                    // If this doesnt default it to 0 on new iteration then simply set the value to 0 at the end of loop
                    let custom_index = 0;
                    for (i in receiver) {
                        // keys from 2 to 8 contain relevant data to display
                        if (custom_index > 1 && custom_index < 9) {
                            let td = document.createElement("td");
                            td.innerHTML = receiver[i];
                            tr.appendChild(td);
                        }

                        if (custom_index === 9) {
                            let td = document.createElement("td");
                            let formatted_date = moment(receiver[i]).format('Do, MMMM Do YYYY, h:mm:ss a');
                            td.innerHTML = formatted_date;
                            tr.appendChild(td);
                        }
                        // key at position 10 = user
                        if (custom_index === 10) {
                            let td = document.createElement("td");
                            td.innerHTML = receiver.user.name;
                            tr.appendChild(td);
                        }
                        if (custom_index === 11) {
                            let td = document.createElement("td");
                            let a = document.createElement("a");
                            // Change href for production environment
                            a.href = "http://127.0.0.1:8000/" + receiver.image;
                            a.innerHTML = "View";
                            td.appendChild(a);
                            tr.appendChild(td);
                        }
                        custom_index++;
                    }
                    insertAfterMe.appendChild(tr);
                }
            }).then(function () {
            //    This to change navigation height to compensate for lack of pagination
            let table_height = document.getElementById("table").clientHeight + 150;
            let nav = document.getElementById("navContainer");
            if (table_height > 1000 ) {
                nav.style.height = table_height;
                // console.log(table_height);
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