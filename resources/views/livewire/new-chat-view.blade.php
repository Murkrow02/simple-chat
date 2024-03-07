

<div class="chats-list">

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
    <div id="category-modal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close-button" onclick="closeModal()">&times;</span>
            <div class="chats-list" id="chat-list-category">

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


    <style>
        /* TODO MOVE TO STYLESHEET FILE */

        /* Styles for the modal container */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        /* Styles for the modal content */
        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        }

        /* Style for the close button */
        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }
    </style>

</div>

<?php
//$alreadyAddedIds = [];
//                <?php
//                // Prevent duplicate chats
//                if (in_array($startableChat->id, $alreadyAddedIds)) {
//                    continue;
//                }
//                $alreadyAddedIds[] = $startableChat->id;
//
?>
