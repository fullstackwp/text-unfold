jQuery(function ($) {
    class TextUnfoldWidgetHandlerClass extends elementorModules.frontend.handlers.Base {
        getDefaultSettings() {
            return {
                selectors: {
                    readMoreSelector: '.fswp-elt--read-more',
                },
            };
        }

        getDefaultElements() {
            const selectors = this.getSettings('selectors');
            return {
                $readMoreSelector: this.$element.find(selectors.readMoreSelector),
            };
        }

        findElement(selector) {
            const $mainElement = this.$element;
            return $mainElement.find(selector).filter(function () {
                return $(this).closest('.elementor-element').is($mainElement);
            });
        }

        bindEvents() {
            let content = this.findElement('.fswp-elt--read-more-content');
            let readMoreButton = this.elements.$readMoreSelector;
            let readMoreText = this.elements.$readMoreSelector.data('more');
            let readLessText = this.elements.$readMoreSelector.data('less');
            let handler = this;

            readMoreButton.on('click', function (e) {
                e.preventDefault();
                let containerHeight = handler.elements.$readMoreSelector.data('height');
                $(this).toggleClass('more');
                if (!$(this).hasClass('more')) {
                    let orginalHeight = content.css('height', 'auto').height();
                    content.height(containerHeight);
                    $(content).animate({
                        height: orginalHeight
                    }, 200);
                    $(this).find('.fswp-elt--read-more-text').html(readLessText);
                    if ($(this).hasClass('show-icon')) {
                        $(this).find('.fswp-elt--read-more-icon.more').hide();
                        $(this).find('.fswp-elt--read-more-icon.less').show();
                    }
                } else {
                    content.animate({
                        height: containerHeight,
                    }, 200);
                    $(this).find('.fswp-elt--read-more-text').html(readMoreText);
                    if ($(this).hasClass('show-icon')) {
                        $(this).find('.fswp-elt--read-more-icon.more').show();
                        $(this).find('.fswp-elt--read-more-icon.less').hide();
                    }
                }
            });
        }
    }


    if (window.elementorFrontend) {
        elementorFrontend.elementsHandler.attachHandler('fswp-text-unfold', TextUnfoldWidgetHandlerClass);
        if (elementorFrontend.isEditMode()) {
            elementor.hooks.addAction('panel/open_editor/widget/fswp-text-unfold', function (panel, model, view) {
                let height = model.attributes.settings.attributes.height['size']
                panel.$el.on('click change keyup keydown input', function () {
                    let newHeight = model.attributes.settings.attributes.height['size']
                    if (height !== newHeight) {
                        height = newHeight;
                        $(view.el).find('.fswp-elt--read-more').data('height', height);
                        if ($(view.el).find('.fswp-elt--read-more').hasClass('more')) {
                            $(view.el).find('.fswp-elt--read-more-content').height(height);
                        }
                    }
                });
            });
        }
    }

});



