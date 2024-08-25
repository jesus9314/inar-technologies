<div id="calendar-event"
    class="event text-gray-500 rounded-md text-xs flex flex-col gap-[2px] justify-between items-start border-l-4 px-1 ml-[-1rem]"
    :class="event.extendedProps.borderColor">
    <span class="font-extralight tracking-tighter leading-none capitalize hidden md:block" x-text="event.title">
    </span>
    <div class="font-medium tracking-tighter leading-none" :class="event.extendedProps.textColor">
        <span x-text="event.extendedProps.starts_at">
        </span>
        -
        <span x-text="event.extendedProps.end_hour">
        </span>
    </div>
</div>
{{-- 
<div class="flex flex-col">
    <span x-text="timeText"></span>
    <span x-text="event.title"></span>
    <span><span x-text="event.extendedProps.participants"></span> participants</span>
</div> --}}
