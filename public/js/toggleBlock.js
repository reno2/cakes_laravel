const toggleBlock = {
    // Основные селекторы и значения
    maxBlockHeight: 200,
    blockSelector: '.js_toggleBlock',
    toggleSelector: '.js_toggleBlockToggler',
    contentSelector: '.js_toggleBlockContent',
    textSelector: '.js_toggleBlockText',
    closeText: 'Скрыть',
    openText: 'Далее',
    init(){
        // кешируем this
        const th = this
        // Вешаем обработчики на селектор и передаём в метод родительский блок target - а
        $(document).on('click', this.toggleSelector, function(){
            th.toggle($(this).closest(th.blockSelector), $(this))
        })
        // перебераем элементы
        $(this.blockSelector).each(function(){
            console.log(this);
            toggleBlock.initBlock($(this))
        })
        // Обрабатываем событие ресайз
        $(window).resize(function () {
            th.onResize();
        });
    },

    isToggle($block){
        if(!$block.data('mode')) return true;

        const modes = $block.data('mode').split(' ');
        const windowWidth = window.innerWidth;

        // Проверяем условия для вывода или скрытия блока
        if(modes.includes('desc') && windowWidth > 1279) return true
        if(modes.includes('tab') && (windowWidth > 768 && windowWidth < 1280)) return true;
        if(modes.includes('mob') && (windowWidth < 768)) return true;

        return false

    },
    onResize(){
        const that = this
        $(this.blockSelector).each(function(){

            const $blockContent = $(this).find( that.contentSelector)
            // Проверяем условие, должен ли блок быть инициализирован на этой ширине экрана.

            // Если блок должен бытьвиден и не инициализирован, показываем блок
            if(that.isToggle($blockContent) && !$(this).hasClass('init')){
                that.initBlock($(this))
                $(this).addClass('init')
                return
            }
            // Если блок не должен быть виден, но виден, скрываем блок
            if(!that.isToggle($blockContent) && $(this).hasClass('init')){
                $(this).removeClass('js_toggleClose init')
                $blockContent.css('max-height', '')
                $(this).find(that.toggleSelector).hide()
                return
            }


            // Если блок раскрыт, пересчитываем высоту
            if($(this).hasClass('js_toggleOpen')){
                const $blockContent = $(this).find( that.contentSelector)
                $blockContent.css('max-height', $blockContent[0].scrollHeight)
            }
        })
    },
    initBlock($block){
        // Инициализируем элемент и либо скрываем управление скрытия/раскрытия
        // либо показзываем
        const $blockContent = $block.find( this.contentSelector)


        if(($blockContent.outerHeight() > this.getMaxBlockHeight($blockContent)) && this.isToggle($blockContent)){
            $blockContent.css('max-height', this.getMaxBlockHeight($blockContent))
            $block.addClass('js_toggleClose init')
            $block.find(this.toggleSelector).show()
        }
        else{
            $block.find(this.toggleSelector).hide()
        }
    },
    // Проверяем если у элемента укзана макс высота возвращаем её если нет,
    // то берём поумолчанию
    getMaxBlockHeight($block){
        let maxBlockHeight = this.maxBlockHeight

        if($block.data('max-height')) {
            maxBlockHeight = $block.data('max-height')
        }
        return maxBlockHeight
    },
    // Обрабатываем раскрытие/скрытие по клику
    toggle($mainBlock, $target){
        let extraClass = null;
        let closest = null;

        // Если нужно добавлят родителю доп. класс возможно нужно будет при сложной вёрстке
        if($mainBlock.data('extra-class'))
            extraClass = $mainBlock.data('extra-class')

        if(extraClass)
            closest = $mainBlock.closest(`.${extraClass}`)

        const $contentBlock = $mainBlock.find(this.contentSelector)
        if($mainBlock.hasClass('js_toggleClose')) {
            // Полностью раскрываем элемент
            $contentBlock.css('max-height',$contentBlock[0].scrollHeight);
            $mainBlock.removeClass('js_toggleClose').addClass('js_toggleOpen');

            // Меняем текс кнопки либо из дата(data-text-close) атрибута либо из значения по умолчанию
            $target.find(this.textSelector).text($target.find(this.textSelector).data('text-close') || this.closeText);
            if(closest) closest.addClass('js_textOpen')
        }else{
            // Блок скрола при закрытие
            const hh = $("header").outerHeight();
            const top = $mainBlock.offset().top - hh;
            // Проверяем если значение атрибута data-no-smooth есть то не скролим до верхнего отступа элемента
            // if(!$contentBlock.data('no-smooth')) {
            //     $('body,html').animate({scrollTop: top}, 500);
            // }

            // Анимируем закрытие
            $contentBlock.animate({
                maxHeight: this.getMaxBlockHeight($contentBlock)
            }, 500);

            // Скрываем элемент
            $mainBlock.removeClass('js_toggleOpen').addClass('js_toggleClose');
            // Меняем значение текста кнопки либо из дата(data-text-open) атрибута либо из значения по умолчанию
            $target.find(this.textSelector).text($target.find(this.textSelector).data('text-open') || this.openText);
            if(closest) closest.removeClass('js_textOpen');
            $contentBlock.css('transition', 'max-height 400ms ease-out')
        }
    }
}

toggleBlock.init()
