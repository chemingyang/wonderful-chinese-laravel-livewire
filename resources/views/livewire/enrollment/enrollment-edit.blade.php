<section>
    <form method="PUT" wire:submit="update" class="flex flex-col max-w-md mx-auto gap-6 bg-slate-900 shadow-2xl rounded-2xl p-4">
        <!-- Course -->
        <flux:select wire:model="form.course_id" :filter="false" label="Course">
            <flux:select.option value="" wire:key="">Select a course</flux:select.option>
            @foreach ($this->courses as $course)
                <flux:select.option value="{{ $course->id }}" wire:key="{{ $course->id }}">
                    {{ $course->title }}
                </flux:select.option>
            @endforeach
        </flux:select>
        <!-- Student -->
        <flux:select wire:model="form.student_id" :filter="false" label="Student">
            <flux:select.option value="" wire:key="">Select a student</flux:select.option>
            @foreach ($this->students as $student)
                <flux:select.option value="{{ $student->id }}" wire:key="{{ $student->id }}">
                    {{ $student->name }}
                </flux:select.option>
            @endforeach
        </flux:select>
        <!-- Status -->
        <flux:select wire:model="form.status" :filter="false" label="Status">
            <flux:select.option value="" wire:key="">Current Status</flux:select.option>
            @foreach (\App\Models\Enrollment::VALID_STATUS as $key => $value)
                <flux:select.option value="{{ $key }}" wire:key="{{ $key }}">{{ $value }}</flux:select.option>
            @endforeach
        </flux:select>
        <flux:textarea
            wire:model="form.note"
            label="Note"
            type="text"
            rows="4"
            placeholder="note"
        />
        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">
                {{ 'Update Enrollment' }}
            </flux:button>
        </div>
    </form>
</section>
