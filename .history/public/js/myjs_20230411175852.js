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
       // Membuat objek JSZip untuk membuat file Excel
       var zip = new JSZip();

       // Membuat folder rels dan menambahkan file .rels ke dalamnya
       var rels = zip.folder('_rels');
       rels.file('.rels', '<?xml version="1.0" encoding="UTF-8"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"></Relationships>');

       // Membuat folder xl dan menambahkan file workbook.xml ke dalamnya
       var xl = zip.folder('xl');
       xl.file('workbook.xml', '<?xml version="1.0" encoding="UTF-8"?><workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"><sheets><sheet name="Sheet1" sheetId="1" r:id="rId1"/></sheets></workbook>');

       // Membuat folder _rels di dalam folder xl dan menambahkan file workbook.xml.rels ke dalamnya
       var xlRels = xl.folder('_rels');
       xlRels.file('workbook.xml.rels', '<?xml version="1.0" encoding="UTF-8"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"></Relationships>');

       // Membuat folder worksheets di dalam folder xl dan menambahkan file sheet1.xml ke dalamnya
       var worksheets = xl.folder('worksheets');
       worksheets.file('sheet1.xml', '<?xml version="1.0" encoding="UTF-8"?><worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"><sheetData><row><c t="s"><v>0</v></c><c t="n"><v>25</v></c></row><row><c t="s"><v>1</v></c><c t="n"><v>30</v></c></row></sheetData></worksheet>');

       // Membuat folder sharedStrings dan menambahkan file sharedStrings.xml ke dalamnya
       var sharedStrings = xl.folder('sharedStrings');
       sharedStrings.file('sharedStrings.xml', '<?xml version="1.0" encoding="UTF-8"?><sst xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" count="2" uniqueCount="2"><si><t>John</t></si><si><t>Alice</t></si></sst>');

       // Membuat file .xlsx menggunakan JSZip
       zip.generateAsync({ type: 'blob' }).then(function (blob) {
           saveAs(blob, 'data.xlsx');
       });
    })
})
