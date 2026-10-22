<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #ffe4ec;
            margin: 0;
        }
        .profile-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }
        .avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: #f8a5c2;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }
        .avatar svg {
            width: 60px;
            height: 60px;
            fill: #ffffff;
        }
        .info-box {
            width: 250px;
            background-color: #f78fb3;
            padding: 12px 20px;
            border-radius: 6px;
            text-align: center;
            font-size: 18px;
            color: #ffffff;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="profile-card">
        <div class="avatar">
            <svg viewBox="0 0 24 24">
                <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z"/>
            </svg>
        </div>
        <div class="info-box">{{ $nama }}</div>
        <div class="info-box">{{ $kelas }}</div>
        <div class="info-box">{{ $npm }}</div>
    </div>
</body>
</html>