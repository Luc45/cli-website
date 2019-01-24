(function ($) {
    $(document).ready(function() {
        /**
         * Listens for a click on my character's Gif
         */
        var Lucas = {
            // The DOM elements that holds my geeky gif.
            el: $('#lucas'),
            img: $('#lucas').find('img'),
            typewrite: $('#lucas').find('#typewrite'),

            // Am I sticky?
            is_sticky: false,

            // Toggle the "is_sticky" state.
            toggle: function() {
                this.is_sticky ? this.unstick() : this.stick();
            },

            stick: function() {
                this.img.addClass('sticky');
                this.img.attr('src', appData.lucasGif.sticky);
                this.is_sticky = true;
            },

            unstick: function() {
                this.img.removeClass('sticky');
                this.img.attr('src', appData.lucasGif.normal);
                this.typewrite.hide();
                this.is_sticky = false;
            },

            transitionEnd: function() {
                if (this.is_sticky) {
                    // Change dialog if music is playing or not.
                    let musicPlaying = appData.is_webradio_active;

                    if (musicPlaying) {
                        var dialog = [
                            {type: 'Whats up! Enjoying the ride?'},
                            {delay: 500},
                            {select: {from: 0, to: 28}},
                            {remove: {num: 28, type: 'whole'}},
                            {type: 'Remember, *K* for my personal selection, *M* for heavy metal... *S* to stop the music.'},
                            {delay: 1000},
                            {type: '<br>'},
                            {type: 'Just don\'t press *R*!'}
                        ]
                    } else {
                        var dialog = [
                            {type: 'Who disturbs my slumber!?'},
                            {delay: 500},
                            {select: {from: 0, to: 32}},
                            {remove: {num: 32, type: 'whole'}},
                            {type: 'Oh, it\'s you! I\'m sorry, I thought it was those bots again.'},
                            {delay: 500},
                            {select: {from: 0, to: 59}},
                            {remove: {num: 59, type: 'whole'}},
                            {type: 'Hey, since we are here, what about we listen to some music?'},
                            {delay: 500},
                            {select: {from: 0, to: 59}},
                            {remove: {num: 59, type: 'whole'}},
                            {type: 'Press *K* to listen to my personal selection, or *M* if you are in the heavy metal mood \\m/.'},
                            {delay: 500},
                            {type: '<br>'},
                            {type: 'Just don\'t press *R*!'}
                        ]
                    }

                    this.typewrite.show();
                    // Typewrite it
                    this.typewrite.typewrite({
                        actions: dialog
                    });
                }
            },

            listen: function() {
                this.img.on('click', function() {
                    Lucas.toggle();
                });

                // On transition end
                this.img.on("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function(e) {
                    Lucas.transitionEnd();
                });
            }
        };

        /**
         * Listens to keybinds related to the webradio.
         */
        var Music = {

            play: function(chosenPlaylist) {
                $.ajax({
                    url: appData.rest.endpoint,
                    type: "POST",
                    dataType: "json",
                    data: {
                        'playlist' : chosenPlaylist,
                        '_wpnonce' : appData.rest.nonce
                    }
                }).done(function() {
                    window.top.location.href = appData.site_url;
                }).fail(function(xhr) {
                    console.error(xhr);
                });
            },

            rickroll: function() {
                var styles = [
                    'background: linear-gradient(#D33106, #571402)'
                    , 'border: 1px solid #3E0E02'
                    , 'color: white'
                    , 'display: block'
                    , 'text-shadow: 0 1px 0 rgba(0, 0, 0, 0.3)'
                    , 'box-shadow: 0 1px 0 rgba(255, 255, 255, 0.4) inset, 0 5px 3px -5px rgba(0, 0, 0, 0.5), 0 -13px 5px -10px rgba(255, 255, 255, 0.4) inset'
                    , 'line-height: 40px'
                    , 'text-align: center'
                    , 'font-weight: bold'
                ].join(';');

                console.log('%c You got RickRolled! Yes, I am aware this is ' + (new Date()).getFullYear() + ' :D ', styles);

                window.open('https://www.youtube.com/watch?v=oHg5SJYRHA0', '_blank');
            },

            listen: function() {
                document.addEventListener("keypress", function onEvent(event) {
                    if (event.key === "k") {
                        Music.play('default');
                    }
                    else if (event.key === "m") {
                        Music.play('metal');
                    }
                    else if (event.key === "s") {
                        Music.play('stop');
                    }
                    else if (event.key === "r") {
                        Music.rickroll();
                    }
                });
            }
        };

        /* Yahoo! */
        Lucas.listen();
        Music.listen();
    });
})(jQuery);

