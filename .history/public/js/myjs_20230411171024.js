(function ($) {
    $.fn.TableKuy = function (data = null) {
        this.wrapInner("<div class='tablekuy-main-cont'></div>");
        var parent = this.parent();
        if (data != null) {
            if (data.tombol != undefined) {
                parent.append("<div class='tablekuy-btn-cont'></div>");
                var btn = data.tombol.map(function (e) {
                    switch (e) {
                        case "print":
                            
                            break;

                        case "print":
                            break;
                        default:
                            break;
                    }
                });
            }
        }
    };
})(jQuery);
