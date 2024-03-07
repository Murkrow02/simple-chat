

<div>

    {{-- Error --}}
    @if($errorMessage)
        <x-chat::alert type="danger" :message="$errorMessage"/>
    @endif

    {{-- Render collapsed categories --}}
    @foreach ($collapsedCategories as $title => $categoryIndex)
        <button onclick="openModal({{$categoryIndex}})">{{$title}}</button>
    @endforeach

    {{-- Render listed categories --}}
    @foreach ($listedCategories as $title => $startableChats)

        {{-- Category title --}}
        <h3>{{$title}}</h3>

        {{-- No data for this category --}}
        @if(count($startableChats) == 0)
            <p>{{__('simple-chat::chat.no_startable_chats')}}</p>
        @endif

        {{-- Render chats --}}
        @foreach ($startableChats as $startableChat)

            <x-chat::chat-cell :id="$startableChat->id"
                               :chatName="$startableChat->name"
                               isNewChat="true"
                               secondLine=""
                               timeStamp=""
                               imageUrl=""/>
        @endforeach
    @endforeach


    <!-- The modal container for lazy-category loading -->
    <div id="category-modal" class="hidden fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex justify-center items-center">

        <!-- Modal content -->
        <div class="bg-white p-20 rounded-lg shadow-lg">
            <span class="absolute top-10 right-10 cursor-pointer" onclick="closeModal()">&times;</span>
            <div class="max-w-600 mx-auto my-20" id="chat-list-category">
            </div>
        </div>
    </div>


    <script>

        // MODAL
        const modal = document.getElementById("category-modal");
        const chatListCategory = document.getElementById("chat-list-category");
        function openModal(categoryIndex) {

            //Show modal
            modal.style.display = "block";

            //Download first page of results
            axios.get(`/chat/loadCategoryPage/${categoryIndex}/0`).then(function(response){
                chatListCategory.innerHTML+= response.data;
            })
        }
        function closeModal() {
            modal.style.display = "none";
        }

        // Set the chat header title
        setChatHeaderTitle('{{__('simple-chat::chat.new_chat')}}');
    </script>

</div>