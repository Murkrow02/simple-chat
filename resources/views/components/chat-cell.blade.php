<div class="flex items-center p-4 border-b border-gray-300 cursor-pointer"
     onclick="
                @if($chatId)
                openChat({{$chatId}}, this)
                @else
                startNewChat({{$userId}}, this)
                @endif
            ">


    <img class="w-[50px] h-[50px] object-cover rounded-full mr-5" alt="user-avatar"/>


    <div class="flex-1">
        <div class="text-black text-lg">{{$chatName}}</div>
        <div class="text-gray-500 text-base">{{$secondLine}}</div>
    </div>


    <div class="text-xs text-gray-500">
        {{$timeStamp}}
    </div>

</div>