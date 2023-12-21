<b>Dear Sir/Madam,</b>
<br><br>
<p>These are the users which have not submitted their timesheet last week.</p>


<div class="table-responsive">
    <table id="examplee" class="display nowrap">
        <thead style="text-align: justify;">
            <th>Name</th>
            <th>Email</th>
            <th>Last Submission date</th>
        </thead>
        <tbody>
            @foreach ($teammember as $teammemberData)
                <tr>
                    <td>{{ $teammemberData->team_member }}</td>
                    <td>{{ $teammemberData->emailid }}</td>
                    <td>{{ $teammemberData->last_submission_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div style="margin-left: 142px;
margin-top: 20px;">
    <button id="exportButton"
        style="background-color: #645959;
    color: white;
    border: none;
    height: 2rem;">Export Data in
        Excell</button>
</div>
<br>
<p>Thanks and Regards<br>Admin<br>V Sankar Aiyar & Co.</p>
{{-- 
<script>
    // Function to convert the table to a downloadable CSV file
    function exportTableToCSV(filename) {
        var csv = [];
        var table = document.getElementById("examplee");
        var rows = table.querySelectorAll("tr");

        // Extract column headers
        var headers = [];
        for (var i = 0; i < rows[0].cells.length; i++) {
            headers.push(rows[0].cells[i].innerText);
        }
        csv.push(headers.join(","));

        // Extract table data
        for (var i = 1; i < rows.length; i++) {
            var row = [];
            var cols = rows[i].querySelectorAll("td");
            for (var j = 0; j < cols.length; j++) {
                row.push(cols[j].innerText);
            }
            csv.push(row.join(","));
        }

        var blob = new Blob([csv.join("\n")], {
            type: "text/csv"
        });
        var url = window.URL.createObjectURL(blob);\
        var a = document.createElement("a");
        a.href = url;
        a.download = filename;
        a.click();

        window.URL.revokeObjectURL(url);
    }

    // Attach the export function to the export button
    document.getElementById("exportButton").addEventListener("click", function() {
        // You can change the filename here
        var filename = "timesheet_data.csv";
        exportTableToCSV(filename);
    });
</script> --}}



<script>
    // Function to convert the table to a downloadable CSV file
    function exportTableToCSV(filename) {
        var csv = [];
        var table = document.getElementById("examplee");
        var rows = table.querySelectorAll("tr");

        // Extract column headers
        var headers = [];
        for (var i = 0; i < rows[0].cells.length; i++) {
            headers.push(rows[0].cells[i].innerText);
        }
        csv.push(headers.join(","));

        // Extract table data
        for (var i = 1; i < rows.length; i++) {
            var row = [];
            var cols = rows[i].querySelectorAll("td");
            for (var j = 0; j < cols.length; j++) {
                row.push(cols[j].innerText);
            }
            csv.push(row.join(","));
        }

        var blob = new Blob([csv.join("\n")], {
            type: "text/csv"
        });
        var url = window.URL.createObjectURL(blob);
        var a = document.createElement("a");
        a.href = url;
        a.download = filename;
        a.click();

        window.URL.revokeObjectURL(url);
    }

    // Attach the export function to the export button
    document.getElementById("exportButton").addEventListener("click", function() {
        // You can change the filename here
        var filename = "timesheet_data.csv";
        exportTableToCSV(filename);
    });
</script>
