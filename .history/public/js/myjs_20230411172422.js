(function ($) {
    $.fn.TableKuy = function (data = null) {
        this.wrapInner(`<div class="table-responsive tablekuy-main-cont"></div>`).;
        var parent = this.parent();
        if (data != null) {
            if (data.tombol != undefined) {
                parent.append("<div class='tablekuy-btn-cont btn-group'></div>");
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
