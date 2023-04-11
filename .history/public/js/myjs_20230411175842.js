(function ($) {
    $.fn.TableKuy = function (data = null) {
        this.wrap(`<div class="table-responsive tablekuy-table-cont"></div>`);
        var parent = this.parent();
        parent.wrap("<div class='tablekuy-main-cont'></div>")
        parent.css({
            "overflow-x":'scroll'
        })
        if (data != null) {
            if (data.tombol != undefined) {
                parent.parent().append("<div class='tablekuy-btn-cont btn-group'></div>");
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

                parent.parent().find(".tablekuy-btn-cont").html(btn)
            }

           
        }
    };
})(jQuery);


$(document).ready(function(){
    $(document).delegate(".download-pdf","click", function(){
        var divContent = $(this).parent().parent().find("table").html();
        var xmlData = '<?xml version="1.0" encoding="UTF-8"?>' +
                          '<?mso-application progid="Excel.Sheet"?>' +
                          '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" ' +
                          'xmlns:o="urn:schemas-microsoft-com:office:office" ' +
                          'xmlns:x="urn:schemas-microsoft-com:office:excel" ' +
                          'xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet" ' +
                          'xmlns:html="http://www.w3.org/TR/REC-html40">' +
                          '<Worksheet ss:Name="Sheet1">' +
                          '<Table>' +
                          '<Row>' +
                          '<Cell><Data ss:Type="String">Nama</Data></Cell>' +
                          '<Cell><Data ss:Type="String">Usia</Data></Cell>' +
                          '</Row>' +
                          '<Row>' +
                          '<Cell><Data ss:Type="String">John</Data></Cell>' +
                          '<Cell><Data ss:Type="Number">25</Data></Cell>' +
                          '</Row>' +
                          '<Row>' +
                          '<Cell><Data ss:Type="String">Alice</Data></Cell>' +
                          '<Cell><Data ss:Type="Number">30</Data></Cell>' +
                          '</Row>' +
                          '</Table>' +
                          '</Worksheet>' +
                          '</Workbook>';

            var blob = new Blob([xmlData], { type: 'application/vnd.ms-excel' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'data.x';
            link.click();
    })
})
