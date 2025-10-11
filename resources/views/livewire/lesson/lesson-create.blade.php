<section>
    <form method="POST" wire:submit="store" class="flex flex-col max-w-md mx-auto gap-6 bg-slate-900 shadow-2xl rounded-2xl p-4">
        <!-- Title -->
        <flux:input
            wire:model="form.title"
            label="Title"
            type="text"
            autofocus
            placeholder="title"  
        />
        <flux:textarea
            wire:model="form.description"
            label="Description"
            type="text"
            rows="4"
            placeholder="description"
        />
         <!-- Course -->
        <flux:select wire:model="form.course_id" :filter="false" label="Course">
            <flux:select.option value="" wire:key="">Select a course</flux:select.option>
            @foreach ($this->courses as $course)
                <flux:select.option value="{{ $course->id }}" wire:key="{{ $course->id }}">
                    {{ $course->title }}
                </flux:select.option>
            @endforeach
        </flux:select>
        <flux:input type="date" label="Scheduled At" wire:model="form.scheduled_at" />
        <flux:input type="date" label="Completed At" wire:model="form.completed_at" />
        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">
                {{ 'Create Lesson' }}
            </flux:button>
        </div>
    </form>
</section>
