function numberToExcelColumn(number) {
    let result = "";
    while (number > 0) {
      const charCode = ((number - 1) % 26) + 65;
      result = String.fromCharCode(charCode) + result;
      number = Math.floor((number - 1) / 26);
    }
    return result;
}

(function ($) {
    $.fn.TableKuy = function (data = null) {
        this.wrap(`<div class="table-responsive tablekuy-table-cont"></div>`);
        var parent = this.parent();
        parent.wrap("<div class='tablekuy-main-cont'></div>");
        parent.css({
            "overflow-x": "scroll",
        });

        parent
            .closest(".tablekuy-main-cont")
            .append("<table class='hidden-table'></table>");

        var newTable = parent
            .closest(".tablekuy-main-cont")
            .find(".hidden-table");

        var th = "<tr>";
        var tb = "";
        var count = 0;

        // th += "</tr>"

        parent
            .closest(".tablekuy-main-cont")
            .find("#table-reservasi")
            .clone()
            .appendTo(".hidden-table");

        newTable
            .find("thead")
            .find("tr")
            .children("th")
            .each(function (e) {
                th += "<th data-table-type='header'>" + $(this).html() + "</th>";
            });

        th += "</tr>";

        count = newTable.find("thead").find("tr").first().children("th").length;

        newTable
            .find("tbody")
            .find("tr")
            .each(function (e) {
                tb += "<tr>";
                $(this)
                    .children("td")
                    .each(function () {
                        tb += "<td>" + $(this).html() + "</td>";
                    });
                tb += "</tr>";
            });

        //Clear
        newTable.html("");
        newTable.html(
                th +
                tb
        );

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

            if (data.judultabel != undefined) {
                let title = data.judultabel.map(function(e){
                    return `<tr class="tablekuy-title-row"><th class='tablekuy-table-title' style="text-align:center" colspan='${count}'>${e}</th></tr>`
                })
                parent.parent().find(".hidden-table").prepend(title+"<tr><td colspan='"+count+"'></td></tr>")
            }
        }
       parent.parent().find(".hidden-table").hide()
    };
})(jQuery);


(function ($) {
    $.fn.Form = function(){
        var element = this.children('input');
        var dataform = {};
        element.each(function(){
            dataform[$(this).attr('name')] = $(this).val()
        });
        return dataform;
    }

    $.fn.Ajax = function(cb){
        var url = this.attr('action');
        var csrf = this.find('._token');
        var method = $(this).attr('method');
        
        
    }


})(jQuery);

$(document).ready(function () {
    $(document).delegate(".download-pdf", "click", function () {
        //Build The Tables

        //alert(count)
        // $(this).closest(".tablekuy-main-cont").find(".hidden-table").table2excel({
        //     exclude: ".excludeThisClass",
        //     name: "Worksheet Name",
        //     filename: "Laporan Penggunaan Layanan Konseling.xls", // do include extension
        //     preserveColors: false // set to true if you want background colors and font colors preserved
        // });

        var divContent = $(this).parent().parent().find(".hidden-table").html();
        // Membuat objek JSZip untuk membuat file Excel
        console.log(XLSX)
        var data = $(this)
            .closest(".tablekuy-main-cont")
            .find(".hidden-table")[0];
        
        console.log(data)

        var excelFile = XLSX.utils.table_to_book(data, { sheet: "sheet1" });

        var worksheet = excelFile.Sheets['sheet1']


        //Styling title
        $(this)
            .closest(".tablekuy-main-cont")
            .find(".hidden-table").children("tr").children(".tablekuy-table-title").each(function(e){
                worksheet["A"+(e+1)].s = {
                    font: {
                        bold: true
                    },
                    alignment: {
                        horizontal: "center"
                    }
                }
            })
        
        //Styling Header

        let counttitle =   $(this)
        .closest(".tablekuy-main-cont")
        .find(".hidden-table").children(".tablekuy-title-row").length + 1;

        $(this)
            .closest(".tablekuy-main-cont")
            .find(".hidden-table").children("tr").children(".tablekuy-table-title").each(function(e){
                worksheet["A"+(e+1)].s = {
                    font: {
                        bold: true
                    },
                    alignment: {
                        horizontal: "center"
                    }
                }
            })
        
        

        XLSX.write(excelFile, {
            bookType: "xlsx",
            bookSST: true,
            type: "base64",
        });
        console.log(excelFile.Sheets["sheet1"]);
        XLSX.writeFile(excelFile, "Laporan Layananan Konseling Individual.xlsx");
    });
});

function renderDummyProfile(nama){
    let photoprofilname = nama.split(" ");
    let inisial = photoprofilname[0][0] + (photoprofilname[1] != undefined ? photoprofilname[1][0] : "");
    return inisial;
}