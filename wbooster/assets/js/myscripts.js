(function($) {
    $.fn.readtime = function(options)
    {
        var defaults = {
            format:  '#',
            wrapper: 'time'
        };

        options = $.extend(defaults, options);

        return this.each(function()
        {

            var text = this.textContent || this.innerText || '';

            var words = text.replace(/(^\s*)|(\s*$)/gi, '')
                            .replace(/[ ]{2,}/gi, ' ').replace(/\n /, '\n')
                            .split(' ').length;

            var time = (words / options.wpm) * 60;

            if (options.images)
            {
                time += ($(this).find('img').length * options.images);
            }

            time = Math.round(time / 60);

            time = options.format.replace(/#/, time);

            var element = document.createElement(options.wrapper);


            function declOfNum(number, titles) {
            cases = [2, 0, 1, 1, 1, 2];
            return titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];
            }

            $('.time_read').html(time+' '+"мин");
        });
    };
}(jQuery));
