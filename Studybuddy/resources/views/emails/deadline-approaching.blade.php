@component('mail::message')
# Deadline Approaching

Hello {{ $user->NAMA }},

We noticed that the deadline for your task is approaching in less than 5 minutes. Please make sure to complete your task on time.

**Task Details:**
- Task: {{ $task->DESK_TUGAS }}
- Deadline: {{ $task->TENGGAT_WAKTU->format('Y-m-d H:i:s') }}

If you have already completed the task, you can ignore this email.

Thank you,<br>
{{ config('app.name') }}
@endcomponent
