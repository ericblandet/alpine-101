<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Laravel</title>

    <!-- Fonts -->
    <link
        href="https://fonts.bunny.net"
        rel="preconnect"
    >
    <link
        href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap"
        rel="stylesheet"
    />
    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine -->
    <script
        defer
        src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"
    ></script>

</head>

<body class="antialiased">
    <div class="mx-auto max-w-2xl">
        <h1 class="my-12 text-center text-4xl text-cyan-400">Alpine.js 101</h1>

        <div x-data="game()">
            <h2 class="text-center text-2xl text-cyan-600">
                <span
                    class="text-2xl font-bold"
                    x-text="points"
                ></span>
                <span class="text-base">pts</span>
                <span class="text-2xl font-bold"> / </span>
                <span
                    class="text-2xl font-bold"
                    x-text="tries"
                ></span>
                <span class="text-base">tries</span>
            </h2>

            <div class="min-h-600 my-10 flex items-center justify-center">
                <div class="grid flex-1 grid-cols-4 gap-10">
                    <template x-for="card in cards">
                        <div>
                            <button
                                class="h-32 w-full"
                                x-show="!card.cleared"
                                :style="'background: ' + (card.flipped ? card.color : '#999')"
                                @click="flip(card)"
                            ></button>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        {{-- flash message --}}
        <div
            class="fixed right-0 bottom-0 m-8 rounded-md bg-green-200 py-2 px-3 text-xs font-bold text-green-600"
            x-data="{ show: false, message: 'Default message' }"
            x-show.transition-opacity="show"
            x-show="show"
            @flash.window=" message=$event.detail.message;
                            show=true;
                            setTimeout(()=> show=false, 1000);"
        >
            <span
                class="pr-6"
                x-text="message"
            ></span>
            <button
                class="inline-block p-1 hover:bg-green-400"
                @click="show=false"
            >&times;</button>
        </div>
    </div>
</body>


<script>
    const pause = (milliseconds = 500) => {
        return new Promise(resolve => setTimeout(resolve, milliseconds))
    }

    const flash = (message) => {
        window.dispatchEvent(new CustomEvent('flash', {
            detail: {
                message
            }
        }))
    }

    const game = () => {
        return {
            cards: [{
                    color: 'aquamarine',
                    flipped: false,
                    cleared: false
                },
                {
                    color: 'aquamarine',
                    flipped: false,
                    cleared: false
                },
                {
                    color: 'GreenYellow',
                    flipped: false,
                    cleared: false
                },
                {
                    color: 'GreenYellow',
                    flipped: false,
                    cleared: false
                },
                {
                    color: 'red',
                    flipped: false,
                    cleared: false
                },
                {
                    color: 'red',
                    flipped: false,
                    cleared: false
                },
                {
                    color: 'aqua',
                    flipped: false,
                    cleared: false
                },
                {
                    color: 'aqua',
                    flipped: false,
                    cleared: false
                },
                {
                    color: 'coral',
                    flipped: false,
                    cleared: false
                },
                {
                    color: 'coral',
                    flipped: false,
                    cleared: false
                },
                {
                    color: 'Violet',
                    flipped: false,
                    cleared: false
                },
                {
                    color: 'Violet',
                    flipped: false,
                    cleared: false
                },
                {
                    color: 'DarkOliveGreen',
                    flipped: false,
                    cleared: false
                },
                {
                    color: 'DarkOliveGreen',
                    flipped: false,
                    cleared: false
                },
                {
                    color: 'DarkOrchid',
                    flipped: false,
                    cleared: false
                },
                {
                    color: 'DarkOrchid',
                    flipped: false,
                    cleared: false
                },
            ].sort(() => Math.random() - .5),

            tries: 0,

            get flippedCards() {
                return this.cards.filter(card => (card.flipped));
            },

            get clearedCards() {
                return this.cards.filter(card => (card.cleared));
            },

            get remainingCards() {
                return this.cards.filter(card => (!card.cleared));
            },

            get points() {
                return this.clearedCards.length;
            },

            async flip(card) {
                if (this.flippedCards.length == 2) {
                    return;
                }

                card.flipped = !card.flipped

                if (this.flippedCards.length == 2) {
                    this.tries += 1;
                    if (this.hasMatch()) {
                        flash('You found a match !')
                        await pause()
                        this.flippedCards.forEach(element => element.cleared = true)

                        if (this.remainingCards.length === 0) {
                            flash(`🎉 You won in ${this.tries} tries ! 🎉`)
                            this.resetGame();
                        }
                    } else {
                        await pause()
                    }

                    this.flippedCards.forEach(card => card.flipped = false);
                }
            },

            hasMatch() {
                return this.flippedCards[0].color === this.flippedCards[1].color
            },

            resetGame() {
                this.tries = 0;
                this.cards.forEach(card => {
                    card.cleared = false
                    card.flipped = false
                })
            }
        }
    }
</script>

</html>
