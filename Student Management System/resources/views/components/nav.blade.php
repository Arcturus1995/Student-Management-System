<nav x-data="{ open: false }" class="bg-gray-800 fixed w-full z-20 top-0 left-0 border-gray-200 px-2 sm:px-4 py-2.5">
    <div class="container flex flex-wrap justify-between item-center mx-auto text-white">
        <a href="/">
            <span class="self-center text-xl font-semibold whitespace-nowrap">
             {{$data['title']}}
            </span>
        </a>
        <button data-collapse-toggle="navbar-main" class="md:hidden" @click="open = !open" >
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg>
        </button>
        <div class="w-full md:block md:w-auto" id="navbar-main" x-show="open">
            <x-items/>
        </div>
        <div class="hidden w-full md:block md:w-auto" id="navbar-main">
            <x-items/>
        </div>
    </div>
</nav>