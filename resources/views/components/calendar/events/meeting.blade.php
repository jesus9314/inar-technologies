<div id="calendar-event"
    class="event text-gray-500 rounded-md text-xs flex flex-col gap-[2px] justify-between items-start border-l-4 px-1 ml-[-1rem]"
    :class="event.extendedProps.borderColor">
    <span class="font-extralight tracking-tighter leading-none capitalize" x-text="event.title">
    </span>
    <div class="font-semibold tracking-tighter" :class="event.extendedProps.textColor">
        <span x-text="event.extendedProps.start_hour">
        </span>
        -
        <span x-text="event.extendedProps.end_hour">
        </span>
    </div>
</div>
