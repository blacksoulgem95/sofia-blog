<div x-data="{
        init(){
            fetch('/index.json')
                .then(response => response.json())
                .then(data => {
                    this.fuse = new window.Fuse(data, {
                        minMatchCharLength: 6,
                        keys: ['title', 'snippet', 'categories'],
                    });
                });
        },
        get results() {
            return this.query ? this.fuse.search(this.query) : [];
        },
        get isQuerying() {
            return Boolean( this.query );
        },
        fuse: null,
        searching: false,
        query: '',
        showInput() {
            this.searching = true;
            this.$nextTick(() => {
                this.$refs.search.focus();
            })
        },
        reset() {
            this.query = '';
            this.searching = false;
        },
    }"
    x-cloak
    class="flex flex-1 justify-end items-center text-right px-4 bg-transparent"
>
    <div
        class="absolute md:relative w-full justify-end bg-transparent left-0 top-0 z-10 mt-7 md:mt-0 px-4 md:px-0"
        :class="{'hidden md:flex': ! searching}"
    >
        <label for="search" class="hidden">Search</label>

        <div class="relative">
            <i class="nes-icon coin is-small absolute left-0 top-0 bottom-0 flex items-center pl-3 text-gray-400"></i>
            <input
                id="search"
                x-model="query"
                x-ref="search"
                class="block h-10 w-full lg:w-1/2 lg:focus:w-3/4 bg-gray-800 border-2 border-[var(--color-trans-pink)] focus:border-[var(--color-trans-light-blue)] outline-none cursor-pointer text-[var(--color-trans-white)] pl-10 pr-4 pb-0 pt-px transition-all duration-200 ease-out placeholder-[var(--color-trans-light-blue)]"
                :class="{ 'rounded-none': query, 'rounded-none': !query }" style="box-shadow: 0 0 10px var(--color-trans-light-blue);"
                autocomplete="off"
                name="search"
                placeholder="Search"
                type="text"
                @keyup.esc="reset"
                @blur="reset"
            >
        </div>

        <button
            x-show="query || searching"
            class="absolute top-0 right-0 leading-snug font-400 text-3xl text-[var(--color-trans-light-blue)] hover:text-[var(--color-trans-pink)] focus:outline-none pr-7 md:pr-3"
            @click="reset"
        >&times;</button>

        <div
            x-show="isQuerying"
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-none"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute left-0 right-0 md:inset-auto w-full lg:w-3/4 text-left mb-4 md:mt-10"
        >
            <div class="flex flex-col bg-black/70 border-2 border-[var(--color-trans-pink)] rounded-none shadow-search mx-4 md:mx-0">
                <template x-for="(result, index) in results">
                    <a
                        class="bg-black/70 hover:bg-gray-900 border-b border-[var(--color-trans-light-blue)] text-[var(--color-trans-white)] cursor-pointer p-4"
                        :class="{ 'rounded-none': (index === results.length - 1) }"
                        :href="result.item.link"
                        :title="result.item.title"
                        :key="result.link"
                        @mousedown.prevent
                    >
                        <span x-html="result.item.title"></span>

                        <span class="block font-normal text-gray-300 text-sm my-1" x-html="result.item.snippet"></span>
                    </a>
                </template>
                <div
                    x-show="! results.length"
                    class="bg-black/70 w-full hover:bg-gray-900 border-b border-[var(--color-trans-light-blue)] rounded-none shadow-none cursor-pointer p-4"
                >
                    <p class="my-0 text-[var(--color-trans-white)]">No results for <strong x-html="query"></strong></p>
                </div>
            </div>
        </div>
    </div>

    <button
        title="Start searching"
        type="button"
        class="flex md:hidden bg-gray-800 hover:bg-gray-900 justify-center items-center border-2 border-[var(--color-trans-light-blue)] rounded-none focus:outline-none h-10 px-3"
        style="box-shadow: 0 0 10px var(--color-trans-light-blue);"
        @click.prevent="showInput"
    >
        <i class="h-4 w-4 nes-icon coin is-small"></i>
    </button>
</div>
