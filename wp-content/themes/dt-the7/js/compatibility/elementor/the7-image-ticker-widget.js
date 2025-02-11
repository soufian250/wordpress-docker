jQuery(function ($) {
    $.imageTicker = function (el) {
        const $widget = $(el),
            tickerContainer = document.querySelector('.elementor-widget-the7-image-ticker-widget'),
            tickerWrapper = document.querySelector('.the7-ticker'),
            originalTicker = document.querySelector('.the7-ticker-content');
        // Store a reference to the object
        $.data(el, "imageTicker", $widget);
        // Private methods
        methods = {
            init: function () {
                $widget.refresh();

                 $widget.layzrInitialisation();
            },
            duplicateContainer: function () {
                let containerWidth = tickerContainer.offsetWidth;
                let wrapperWidth = originalTicker.scrollWidth;
                const maxClones = 10; 
                let cloneCount = 0;
        
                // Clear any previously added tickers
                tickerWrapper.innerHTML = '';
        
                // Add the original ticker once
                tickerWrapper.appendChild(originalTicker.cloneNode(true));
                // Duplicate until the total width exceeds the container's width
                while ($('.the7-ticker-content', $widget).width()*cloneCount < tickerContainer.offsetWidth*2) {
                    if (cloneCount >= maxClones) {
                        console.warn("Reached maximum clone limit, exiting loop to avoid infinite loop.");
                        break;
                    }
                    
                    tickerWrapper.appendChild(originalTicker.cloneNode(true));
                    cloneCount++;
                }
                $widget.find(".is-loading").removeClass("is-loading").addClass("is-loaded");
                $(".is-loaded", tickerWrapper).parent().removeClass("layzr-bg");

            },
            
            handleResize: function () {
                methods.duplicateContainer();
            },
            bindEvents: function () {
                elementorFrontend.elements.$window.on('the7-resize-width-debounce', methods.handleResize);
            },
            unBindEvents: function () {
                elementorFrontend.elements.$window.off('the7-resize-width-debounce', methods.handleResize);
            },
        };

        $widget.refresh = function () {
            methods.unBindEvents();
            methods.bindEvents();
            methods.handleResize();
        };
        $widget.delete = function () {
            methods.unBindEvents();
            $widget.removeData("imageTicker");
        };
        methods.init();
    };
    $.fn.imageTicker = function () {
        return this.each(function () {
            var widgetData = $(this).data('imageTicker');
            if (widgetData !== undefined) {
                widgetData.delete();
            }
            new $.imageTicker(this);
        });
    };
});
(function ($) {
    // Make sure you run this code under Elementor.
    $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/the7-image-ticker-widget.default", function ($widget, $) {
            $(document).ready(function () {
                $widget.imageTicker();
            })
        });

    });
})(jQuery);
