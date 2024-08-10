{{-- <div class="flex flex-col">
    <span x-text="timeText"></span>
    <span x-text="event.title"></span>
    <span><span x-text="event.extendedProps.participants"></span> participants</span>
</div> --}}


<div class="bottom flex-grow h-30 py-1 w-full cursor-pointer">
    <div class="event bg-blue-400 text-white rounded p-1 text-sm mb-1 flex flex-col">
        <span class="event-name" x-text="event.title">
        </span>
        </span>
        <span class="time" x-text="event.extendedProps.start_hour">
        </span>
        <span><span x-text="event.extendedProps.participants"></span> participantes</span>
    </div>
</div>
