(function ($) {
    $.fn.TableKuy = function (data = null) {
        this.wrap(`<div class="table-responsive tablekuy-table-cont"></div>`);
        var parent = this.parent();
        parent.wrap("<div class='tablekuy-main-cont'></div>");
        parent.css({
            "overflow-x": "scroll",
        });
        if (data != null) {
            if (data.tombol != undefined) {
                parent
                    .parent()
                    .append("<div class='tablekuy-btn-cont btn-group'></div>");
                var btn = data.tombol.map(function (e) {
                    switch (e) {
                        case "print":
                            return `<button class='btn btn-info'><i class='fa fa-print'></i></button>`;
                            break;

                        case "pdf":
                            return `<button class='btn btn-danger download-pdf'><i class='fa fa-print'></i></button>`;
                            break;

                        case "excel":
                            return `<button class='btn btn-success'><i class='fa fa-print'></i></button>`;
                            break;
                        default:
                            break;
                    }
                });

                parent.parent().find(".tablekuy-btn-cont").html(btn);
            }
        }
    };
})(jQuery);

$(document).ready(function () {
    $(document).delegate(".download-pdf", "click", function () {
        //Build The Tables
        $(this).closest(".tablekuy-main-cont").append("<div class='hidden-table'></div>")

        var newTable = $(this).closest(".tablekuy-main-cont").find(".hidden-table");
        
        var th = "<tr>";
        var tb = "";

       // th += "</tr>"
      
       
      

        $(this).closest(".tablekuy-main-cont").find("#table-reservasi").clone().appendTo(".hidden-table")

        newTable.find("thead").find("tr").children("th").each(function(e){
      
           th += "<th>"+$(this).html()+"</th>"
        })

        newTable.find("tbody").find("tr").each(function(e){
            tb += "<tr>"
            $(this).children("td").each(function(){
                tb += "<td>"+$(this).html()+"</td>"
            })
            tb += "</tr>"
        })



        alert(tb);



        // $(this).closest(".tablekuy-main-cont").find("#table-reservasi").table2excel({
        //     exclude: ".excludeThisClass",
        //     name: "Worksheet Name",
        //     filename: "Laporan Penggunaan Layanan Konseling.xls", // do include extension
        //     preserveColors: false // set to true if you want background colors and font colors preserved
        // });

        // var divContent = $(this).parent().parent().find("table").html();
        // // Membuat objek JSZip untuk membuat file Excel
        // var data = $(this)
        //     .closest(".tablekuy-main-cont")
        //     .find("#table-reservasi")[0];

        // var excelFile = XLSX.utils.table_to_book(data, { sheet: "sheet1" });


        
        // var worksheet = excelFile.Sheets['sheet1']
        // console.log(worksheet)

        // for (let i = 3; i >= 1; i--) {
        //     const row = i + 3;
        //     const newRow = i;
        //     const rowRef = XLSX.utils.encode_row(row);
        //     const newRowRef = XLSX.utils.encode_row(newRow);
          
        //     // Loop dari kolom pertama ke kolom terakhir
        //     for (let j = 1; j <= 8; j++) {
        //       const colRef = XLSX.utils.encode_col(j);
        //       const cellRef = colRef + rowRef;
        //       const newCellRef = colRef + newRowRef;
          
        //       // Salin nilai sel ke sel baru yang digeser ke bawah
        //       if (worksheet[cellRef]) {
        //         worksheet[newCellRef] = Object.assign({}, worksheet[cellRef]);
        //       }
          
        //       // Hapus nilai sel asal   
        //       delete worksheet[cellRef];
        //     }
        //   }

         
          
          
          
          
          
          

        XLSX.write(excelFile, {
            bookType: "xlsx",
            bookSST: true,
            type: "base64",
        });
        console.log(excelFile.Sheets["sheet1"]);
        XLSX.writeFile(excelFile, "Laporan Layana Konseling Individual.xlsx");
    });
});
