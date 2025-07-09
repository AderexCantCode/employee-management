@extends('layouts.app')

@section('title', 'Transfer Task')

@section('content')
<div class="relative w-[667px] h-[673px] bg-white rounded-[15px] shadow mx-auto my-12">
    <!-- Header -->
    <div class="absolute top-[21px] left-[66px] flex justify-between items-center w-[549px] h-[24px]">
        <h1 class="text-[20px] font-medium text-[#111111]">Transfer Task</h1>
        <a href="{{ url()->previous() }}" class="w-[19px] h-[19px] bg-[#7D7D7D] rounded-full flex items-center justify-center hover:bg-[#555]">
            <span class="text-white text-xs">&#10005;</span>
        </a>
    </div>
    <!-- Divider -->
    <div class="absolute top-[61px] left-0 w-full border-t border-[#7D7D7D]"></div>
    <form action="{{ route('task.transfer.submit') }}" method="POST">
        @csrf
        <!-- Task Label -->
        <div class="absolute top-[107px] left-[65px] text-[#7D7D7D] text-[16px] font-medium">
            Task
        </div>
        <!-- Task Input -->
        <div class="absolute top-[134px] left-[65px] w-[538px] h-[53px]">
            <select name="task_id" required class="w-full h-full bg-[#F4F4F4] rounded-[5px] px-[21px] text-[#111] text-[16px] focus:outline-none">
                <option value="" disabled selected>Task name...</option>
                @foreach($tasks as $task)
                    <option value="{{ $task->id }}">{{ $task->title }}</option>
                @endforeach
            </select>
        </div>
        <!-- Project Label -->
        <div class="absolute top-[207px] left-[65px] text-[#7D7D7D] text-[16px] font-medium">
            Project
        </div>
        <!-- Project Dropdown -->
        <div class="absolute top-[234px] left-[65px] w-[538px] h-[53px]">
            <select name="project_id" required class="w-full h-full bg-[#F4F4F4] rounded-[5px] px-[21px] text-[#111] text-[16px] focus:outline-none">
                <option value="" disabled selected>Select project</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
        </div>
        <!-- Send to Label -->
        <div class="absolute top-[307px] left-[65px] text-[#7D7D7D] text-[16px] font-medium">
            Send to
        </div>
        <!-- Employee Dropdown -->
        <div class="absolute top-[334px] left-[65px] w-[538px] h-[53px]">
            <select name="user_id" required class="w-full h-full bg-[#F5F5F5] rounded-[5px] px-[21px] text-[#111] text-[16px] focus:outline-none">
                <option value="" disabled selected>Select employee</option>
                @foreach($employees as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <!-- Task Level Label -->
        <div class="absolute top-[415px] left-[65px] flex items-center gap-[26px] w-[380px] h-[21px]">
            <span class="text-[#111111] text-[17px] font-medium">Task Level</span>
            <!-- Low -->
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="radio" name="level" value="low" class="hidden" required>
                <div class="w-[18px] h-[18px] border-2 border-[#FFB42E] rounded-full flex items-center justify-center"></div>
                <span class="text-[#111111] text-[17px] font-medium">Low</span>
            </label>
            <!-- Medium -->
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="radio" name="level" value="medium" class="hidden" required>
                <div class="w-[18px] h-[18px] border-2 border-[#FFB42E] rounded-full flex items-center justify-center"></div>
                <span class="text-[#111111] text-[17px] font-medium">Medium</span>
            </label>
            <!-- High -->
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="radio" name="level" value="high" class="hidden" required>
                <div class="w-[18px] h-[18px] border-2 border-[#FFB42E] rounded-full flex items-center justify-center"></div>
                <span class="text-[#111111] text-[17px] font-medium">High</span>
            </label>
        </div>
        <!-- Task Time Info -->
        <div class="absolute top-[452px] left-[65px] w-[538px] h-[48px] bg-[#FAFAFA] rounded-[5px] px-[21px] py-[12px] flex flex-col justify-center gap-[10px]">
            <div class="flex justify-between w-full text-[#EA4949] text-[16px] font-medium">
                <span>Low : &gt; 2 hours</span>
                <span>Medium : &gt; 6 hours</span>
                <span>High : &lt; 6 hours</span>
            </div>
        </div>
        <!-- Submit Button -->
        <button type="submit" class="absolute top-[552px] left-[65px] w-[538px] h-[65px] bg-[#111111] rounded-[10px] flex items-center justify-center text-white text-[24px] font-normal hover:bg-[#222]">
            Submit
        </button>
    </form>
</div>
@endsection
