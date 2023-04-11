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

            parent.find(".download-pdf").click(function(){
                alert('tes');
            })
        }
    };
})(jQuery);
