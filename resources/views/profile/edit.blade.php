@extends('layouts.app')

@section('content')
<div class="profile-container">
    <div class="profile-card">
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            <!-- Hapus @method('PUT') karena route hanya menerima POST -->

            <div class="profile-content">
                <!-- Left Column - Profile Info -->
                <div class="profile-left">
                    <!-- Profile Header -->
                    <div class="profile-header">
                        <div class="profile-avatar">
                            @if($user->avatar)
                                <img src="{{ asset($user->avatar) }}" alt="Profile Picture" class="avatar-image">
                            @else
                                <div class="avatar-placeholder"></div>
                            @endif
                        </div>
                        <div class="profile-info">
                            <div class="profile-name-section">
                                <h1 class="profile-name">{{ $user->name }}</h1>
                                <p class="profile-role">{{ ucfirst($user->role ?? 'Admin') }}</p>
                            </div>
                            <div class="profile-actions">
                                <label for="avatar" class="change-picture-btn">
                                    <input type="file" id="avatar" name="avatar" accept="image/*" style="display: none;">
                                    Change Picture
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Section -->
                    <div class="profile-stats">
                        <div class="stat-item">
                            <span class="stat-label">Project Total</span>
                            <div class="stat-value">{{ $user->projects_count ?? 10 }}</div>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Tasks Done</span>
                            <div class="stat-value">{{ $user->tasks_done ?? 144 }}</div>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Total Leave</span>
                            <div class="stat-value">{{ $user->leave_days ?? 4 }}</div>
                        </div>
                    </div>

                    <!-- Work Hours -->
                    <div class="work-hours">
                        <span class="work-hours-label">Work hours</span>
                        <div class="progress-container">
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 70%"></div>
                            </div>
                            <span class="progress-text">70%</span>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Edit Form -->
                <div class="profile-right">
                    <div class="edit-header">
                        <button type="submit" class="edit-btn">Save</button>
                    </div>

                    <div class="form-sections">
                        <!-- Form Fields -->
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" name="name" value="{{ $user->name }}" class="form-input" required>
                            </div>

                            <div class="form-group">
                                <label for="status" class="form-label">Status</label>
                                <select id="status" name="status" class="form-input" required>
                                    <option value="ready" {{ $user->status == 'ready' ? 'selected' : '' }}>Ready</option>
                                    <option value="standby" {{ $user->status == 'standby' ? 'selected' : '' }}>Standby</option>
                                    <option value="not_ready" {{ $user->status == 'not_ready' ? 'selected' : '' }}>Not Ready</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" value="{{ $user->email }}" class="form-input" readonly>
                            </div>

                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" placeholder="Leave blank to keep current password" class="form-input">
                            </div>

                            <div class="form-group">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" id="phone" name="phone" value="{{ $user->phone ?? '0867744666778' }}" class="form-input">
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password" class="form-input">
                            </div>

                            <div class="form-group">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" id="address" name="address" value="{{ $user->address ?? 'Semarang, Central Java' }}" class="form-input">
                            </div>

                            <div class="form-group">
                                <label for="birth_date" class="form-label">Birth Date</label>
                                <input type="date" id="birth_date" name="birth_date" value="{{ $user->birth_date ?? '2006-02-13' }}" class="form-input">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.profile-container {
    position: relative;
    width: 100%;
    min-height: calc(100vh - 120px);
    background: #f5f5f5;
    padding: 20px;
    margin: 0;
    box-sizing: border-box;
}

.profile-card {
    position: relative;
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    background: #FFFFFF;
    box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.25);
    border-radius: 20px;
    padding: 40px 50px;
    box-sizing: border-box;
    overflow: hidden;
}

.profile-content {
    display: flex;
    gap: 50px;
    align-items: flex-start;
}

.profile-left {
    display: flex;
    flex-direction: column;
    gap: 35px;
    width: 100%;
    max-width: 350px;
    flex-shrink: 0;
}

.profile-header {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 25px;
    width: 100%;
    height: 100px;
}

.profile-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    overflow: hidden;
    background: #e0e0e0;
    flex-shrink: 0;
}

.avatar-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-placeholder {
    width: 100%;
    height: 100%;
    background: #e0e0e0;
}

.profile-info {
    display: flex;
    flex-direction: column;
    gap: 10px;
    width: 100%;
    max-width: 220px;
}

.profile-name-section {
    display: flex;
    flex-direction: column;
    gap: 4px;
    width: 100%;
}

.profile-name {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 24px;
    line-height: 28px;
    color: #111111;
    margin: 0;
}

.profile-role {
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    font-size: 16px;
    line-height: 20px;
    color: #7D7D7D;
    margin: 0;
}

.profile-actions {
    display: flex;
    flex-direction: row;
    align-items: center;
    width: 100%;
    height: 32px;
}

.change-picture-btn {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 5px 12px;
    width: 130px;
    height: 32px;
    background: #6FAEC9;
    border-radius: 8px;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 14px;
    line-height: 18px;
    color: #FFFFFF;
    cursor: pointer;
    border: none;
    transition: background 0.3s ease;
}

.change-picture-btn:hover {
    background: #5a9bb0;
}

.profile-stats {
    display: flex;
    flex-direction: column;
    gap: 18px;
    width: 100%;
}

.stat-item {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    height: 40px;
}

.stat-label {
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    font-size: 18px;
    line-height: 22px;
    color: #7D7D7D;
    flex: 1;
}

.stat-value {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 6px 14px;
    width: 100px;
    height: 40px;
    background: #FFFFFF;
    box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.25);
    border-radius: 8px;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 20px;
    line-height: 24px;
    color: #020202;
    box-sizing: border-box;
}

.work-hours {
    display: flex;
    flex-direction: column;
    gap: 12px;
    width: 100%;
}

.work-hours-label {
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    font-size: 16px;
    line-height: 20px;
    color: #7D7D7D;
}

.progress-container {
    position: relative;
    width: 100%;
    height: 28px;
}

.progress-bar {
    width: 100%;
    height: 28px;
    background: #C3C3C3;
    border-radius: 25px;
    overflow: hidden;
}

.progress-fill {
    height: 28px;
    background: #25345B;
    border-radius: 25px;
    transition: width 0.3s ease;
}

.progress-text {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    font-size: 16px;
    line-height: 20px;
    color: #FFFFFF;
}

.profile-right {
    display: flex;
    flex-direction: column;
    gap: 25px;
    width: 100%;
    flex: 1;
}

.edit-header {
    display: flex;
    justify-content: flex-end;
    width: 100%;
}

.edit-btn {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 8px 20px;
    width: 120px;
    height: 38px;
    background: #111111;
    border-radius: 8px;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 16px;
    line-height: 20px;
    color: #FFFFFF;
    border: none;
    cursor: pointer;
    transition: background 0.3s ease;
}

.edit-btn:hover {
    background: #333333;
}

.form-sections {
    width: 100%;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px 30px;
    width: 100%;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
    width: 100%;
}

.form-label {
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    font-size: 16px;
    line-height: 20px;
    color: #7D7D7D;
}

.form-input {
    display: flex;
    align-items: center;
    padding: 11px 16px;
    width: 100%;
    height: 45px;
    background: #FFFFFF;
    box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.15);
    border-radius: 15px;
    border: none;
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    font-size: 16px;
    line-height: 20px;
    color: #111111;
    box-sizing: border-box;
}

.form-input:focus {
    outline: none;
    box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.25);
}

.form-input[readonly] {
    background: #f5f5f5;
    color: #7D7D7D;
}

/* Responsive adjustments */
@media (max-width: 1200px) {
    .profile-content {
        flex-direction: column;
        gap: 30px;
    }

    .profile-left {
        max-width: 100%;
    }

    .profile-right {
        max-width: 100%;
    }

    .form-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
}

@media (max-width: 768px) {
    .profile-container {
        padding: 15px;
    }

    .profile-card {
        padding: 20px;
    }

    .profile-content {
        gap: 20px;
    }

    .profile-header {
        flex-direction: column;
        height: auto;
        gap: 15px;
    }

    .profile-info {
        max-width: 100%;
        text-align: center;
    }

    .profile-stats {
        gap: 15px;
    }

    .stat-item {
        height: auto;
        padding: 10px 0;
    }

    .form-grid {
        gap: 15px;
    }
}

/* Override any conflicting styles from layout */
.profile-container * {
    box-sizing: border-box;
}

/* Ensure proper spacing in layout */
@media (min-width: 768px) {
    .profile-container {
        max-width: calc(100vw - 320px);
        margin-left: 0;
    }
}
</style>
@endsection
