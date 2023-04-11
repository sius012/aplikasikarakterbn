(function ($) {
    $.fn.TableKuy = function (data = null) {
        this.wrapInner(`<div class="table-responsive tablekuy-table-cont"></div>`);
        var parent = this.parent();
        parent.wrapInner("<div class='tablekuy-main-cont'></div>")
        parent.css({
            "overflow-x":'scroll'
        })
        if (data != null) {
            if (data.tombol != undefined) {
                parent.closest(".tablekuy").after("<div class='tablekuy-btn-cont btn-group'></div>");
                var btn = data.tombol.map(function (e) {
                    switch (e) {
                        case "print":
                            return `<button class='btn btn-info'><i class='fa fa-print'></i></button>`;
                            break;

                        case "pdf":
                            return `<button class='btn btn-danger'><i class='fa fa-print'></i></button>`;
                            break;

                        case "excel":
                            return `<button class='btn btn-success'><i class='fa fa-print'></i></button>`;
                            break;
                        default:
                            break;
                    }
                });

                parent.find(".tablekuy-btn-cont").html(btn)
            }
        }
    };
})(jQuery);
