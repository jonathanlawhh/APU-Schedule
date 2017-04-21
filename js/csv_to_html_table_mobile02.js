var CsvToHtmlTableMobile2 = CsvToHtmlTableMobile2 || {};

CsvToHtmlTableMobile2 = {
    init: function (options) {

      options = options || {};
      var csv_path = options.csv_path || "";
      var el = options.element || "table-container";
      var allow_download = options.allow_download || false;
      var csv_options = options.csv_options || {};
      var datatables_options = options.datatables_options || {};

      $("#" + el).html("<table class='table table-striped table-condensed' id='" + el + "-table'></table>");

      $.when($.get(csv_path)).then(
        function(data){      
          var csv_data = $.csv.toArrays(data, csv_options);
		  
          var table_head = "<thead><tr><th>Date</th><th>Time</th><th>Location</th><th>Classroom</th>";

          table_head += "</tr></thead>";
          $('#' + el + '-table').append(table_head);
          $('#' + el + '-table').append("<tbody></tbody>");

          for (row_id = 0; row_id < csv_data.length; row_id++) { 
            var row_html = "<tr>";
			
            //takes in an array of column index and function pairs
            for (col_id = 2; col_id <= 5; col_id++) { 
              row_html += "<td>" + csv_data[row_id][col_id] + "</td>";
            }
              
            row_html += "</tr>";
            $('#' + el + '-table tbody').append(row_html);
          }

          $('#' + el + '-table').DataTable(datatables_options);
		  document.getElementById("status").innerHTML = "";
        });
    }
}
