# 📁 Real-Time File Management System

<p align="center">
  <img src="assets/240906093-9be4d344-6782-461a-b5a6-32a07bf7b34e.gif" alt="Welcome Animation" width="600" height="400">
</p>

![GitHub Repo](https://img.shields.io/github/repo-size/hemantgowardipe/files_management_system)
![License](https://img.shields.io/badge/license-MIT-green)
![Contributions](https://img.shields.io/badge/contributions-welcome-brightgreen)

---

## 📚 Table of Contents

- [Overview](#-overview)
- [Features](#-features)
- [Workflow](#-workflow)
- [Tech Stack](#-tech-stack)
- [Installation & Setup](#-installation--setup)
- [API Endpoints](#-api-endpoints)
- [Future Enhancements](#-future-enhancements)
- [Contributing](#-contributing)
- [Show Your Support](#-show-your-support)
- [Contact](#-contact)
- [Live Demo & Screenshots](#-live-demo--screenshots)

---

## 🚀 Overview

A powerful **Real-Time File Management System** designed for efficient file handling, secure access control, and live synchronization, ensuring seamless collaboration.

---

## ✨ Features

- 📂 **Instant File Management** – Upload, modify, and delete files in real time with just a few clicks.
- 🔄 **Live Synchronization** – Experience immediate updates across all users for a seamless workflow.
- 🔒 **Secure Access** – Benefit from role-based authentication to keep your files safe.
- ☁️ **Cloud Storage Ready** – Enjoy secure file storage capabilities with easy access from anywhere.
- 🎛️ **Admin Dashboard** – Monitor and manage your system comprehensively with our intuitive dashboard.
- 📱 **Responsive UI** – Our UI is built with JavaScript, jQuery UI, Tailwind CSS & Bootstrap, ensuring it looks great on any device.
- ✉️ **OTP Email Verification** – Enhance security with OTP for user authentication.
- 👤 **Dynamic Profile Page** – View and manage all your details in one place, with a modern and user-friendly interface.
- 📊 **Analytics Dashboard** – Gain insights into file usage and system performance with detailed analytics.

---

## 🔄 Workflow
```mermaid
graph TD;
    %% User Authentication
    A[User Registers/Login] -->|Email Verification| B{Authentication}
    B -->|Valid User| C[Dashboard Access]
    B -->|Forgot Password| D[OTP-Based Password Reset]

    %% Core Functionalities
    C --> E[Upload File] 
    C --> F[Preview File] 
    C --> G[Rename/Delete File] 
    C --> H[Share File]

    %% Security & Access Control
    E -->|Apply Security| I[End-to-End Encryption]
    I -->|RBAC Applied| J[Access Control Verification]

    %% User Profile & Tracking
    C --> K[Profile Section]
    K --> L[Time Tracking & Session Monitoring]

    %% Work in Progress
    subgraph "🚧 Work in Progress 🚧"
        M[Network Simulation] --> P[Optimize File Transfer]
        N[Cloud Integration] --> Q[Scalability & Redundancy]
        O[Social Media Sharing] --> R[API-Based File Sharing]
    end

    %% Connecting Work in Progress Features
    C --> M
    C --> N
    C --> O
```

---

## 🏗 Tech Stack

<p align="center">
  <img src="https://img.shields.io/badge/Frontend-JavaScript-yellow" alt="Frontend: JavaScript">
  <img src="https://img.shields.io/badge/Frontend-jQuery_UI-blue" alt="Frontend: jQuery UI">
  <img src="https://img.shields.io/badge/Frontend-Tailwind_CSS-0d6efd" alt="Frontend: Tailwind CSS">
  <img src="https://img.shields.io/badge/Frontend-Bootstrap-563d7c" alt="Frontend: Bootstrap">
  <img src="https://img.shields.io/badge/Frontend-daisyUI-0d6efd" alt="Frontend: daisyUI">
  <img src="https://img.shields.io/badge/Backend-PHP-787cb5" alt="Backend: PHP">
  <img src="https://img.shields.io/badge/Backend-PhpMyAdmin-787cb5" alt="Backend: PhpMyAdmin">
  <img src="https://img.shields.io/badge/Backend-PhpMailer-787cb5" alt="Backend: PhpMailer">
  <img src="https://img.shields.io/badge/Database-MySQL-00758f" alt="Database: MySQL">
</p>

---

## 🛠 Installation & Setup

### Prerequisites

Ensure you have the following installed:
- PHP & MySQL
- A web server (e.g., Apache, Nginx)

### Steps

1. **Clone the repository**:  
   ```sh
   git clone https://github.com/hemantgowardipe/files_management_system.git
   ```
2. **Set up the backend**:  
   ```sh
   cd backend
   Configure database connection in `config.php`
   ```
3. **Set up the frontend**:  
   ```sh
   cd frontend
   Open `index.html` in a browser
   ```
4. **Start the backend server**:  
   ```sh
   php -S localhost:8000 -t backend
   ```

---

## 📡 API Endpoints

| Method  | Endpoint               | Description           |
|---------|------------------------|-----------------------|
| `POST`  | `/api/auth/register`   | Register a user       |
| `POST`  | `/api/auth/login`      | Authenticate user     |
| `GET`   | `/api/files`           | Fetch all files       |
| `POST`  | `/api/files/upload`    | Upload a file         |
| `DELETE`| `/api/files/{id}`      | Delete a file         |

---

## 🔮 Future Enhancements

- ☁ **Cloud Integration** – Advanced cloud computing features.  
- 🌐 **Network Simulation** – Enhanced system performance & scalability.  
- 🛡 **Advanced Security Features** – Enhanced security measures and encryption.

---

## 🤝 Contributing

🙌 Contributions are welcome! Follow these steps:
1. Fork the repository & create a new branch.
2. Commit your changes & push them.
3. Open a pull request.

---

## 🌟 Show Your Support

Give a ⭐ if you like this project!

---

## 📬 Contact

📧 Email: rajugowardipe0@gmail.com  
🐙 GitHub: [hemantgowardipe](https://github.com/hemantgowardipe)

---

## 🌐 Live Demo & Screenshots

<p align="center">
  <img src="assets/Screenshot 2025-03-05 235321.png" alt="Screenshot 1" width="400" height="250">
  <img src="assets/Screenshot 2025-03-05 235203.png" alt="Screenshot 2" width="400" height="250" >
  <img src="assets/Screenshot 2025-03-05 235300.png" alt="Screenshot 1" width="400" height="250">
  <img src="assets/Screenshot 2025-03-05 235419.png" alt="Screenshot 2" width="400" height="250">
  <img src="assets/Screenshot 2025-03-05 235453.png" alt="Screenshot 1" width="400" height="250">
  <img src="assets/Screenshot 2025-03-05 235609.png" alt="Screenshot 2" width="400" height="250">
</p>

---

<p align="center">
  <pre>
  ████████████████████████████████████████████████████  ██╗  ██╗███████╗██╗     ██╗      ██████╗
  ████████████████████████████████████████████████████  ██║  ██║██╔════╝██║     ██║     ██╔═══██╗
  ████████████████████████████████`.        ╙█████████  ███████║█████╗  ██║     ██║     ██║   ██║
  █████████████████████████████▀  ¿▓▓▓▓▓▓▓▓▄/ "███████  ██╔══██║██╔══╝  ██║     ██║     ██║   ██║
  ███████████████████████████▀.  ▓▓▓▓▓▓▓▓▓▓▓▓   ▐█████  ██║  ██║███████╗███████╗███████╗╚██████╔╝▄█╗
  ███████████████████████████ `  ▓▓▓▓▓▓▓▓▓▓▓▓  ` █████  ╚═╝  ╚═╝╚══════╝╚══════╝╚══════╝ ╚═════╝ ╚═╝
  ███████████████████████████ `  ▓▓▓▓▓▓▓▓▓▓▓▓   ▄█████
  ▀██████████████████████████▌  ▀▀▓▓▓▓▓▓▓▌╓╖. ███████  ███╗   ██╗██╗ ██████╗███████╗  ████████╗ ██████╗
  █▄▀██████████████████████████▄ ╩╦╙▀▀▀▀▀ ╣`,████████  ████╗  ██║██║██╔════╝██╔════╝  ╚══██╔══╝██╔═══██╗
  ▄▀█▄╙█████████████████████▀▀▀▀█████▄▄ .... ,▄██████  ██╔██╗ ██║██║██║     █████╗       ██║   ██║   ██║
  ██▄▀█▄╙█████████████████▀  ╪╢%╦══~╓,└ ╚▒▒▒ ╙▀|,╓╓═╤H   ▀█  ██║╚██╗██║██║██║     ██╔══╝       ██║   ██║   ██║
  █▀▀▀-▀█▌▄▀█████████████   ║▒▒▒▒▒▒▒▒▒▒╢╦ ╘ -╣▒▒▒▒▒▒▒▒▒╢╕   ▀  ██║ ╚████║██║╚██████╗███████╗     ██║   ╚██████╔╝
  ██▄▀██└║▄▄▄████████████▄          ═╕╕╕╕╕═╕═══════       ▄▄▄▄  ╚═╝  ╚═══╝╚═╝ ╚═════╝╚══════╝     ╚═╝    ╚═════╝
  ████▄▀█▌║███  ████████▌         ╕   ╩▒▒▒▒▒▒▒▒▒Ñ          ███
  ███████▌Ö▓▌   ▀██████████`╔▒▒╣ █ ▒▒m   ╚▒╢▒▒▒╩ -╣▒ ▌ ▒▒▒ ████  ███╗   ███╗███████╗███████╗████████╗  ██╗   ██╗ ██████╗ ██╗   ██╗
  ████ -"" ∞╙,▀.╙▀███████╜ ▒▒▒ ▄█ Ñ   -   S.  ═▒▒▒▒ █ ║▒▒╕└███  ████╗ ████║██╔════╝██╔════╝╚══██╔══╝  ╚██╗ ██╔╝██╔═══██╗██║   ██║
  ████████▄ -«   ∞▄.▀",╓═     ╒██   ═╣▒▒ `Ñ╛        █▌ ▒▒▒ ███  ██╔████╔██║█████╗  █████╗     ██║      ╚████╔╝ ██║   ██║██║   ██║
  █████████▌ º     ╤╣▒╣╩^",▄▄███▀  ▒▒╣"     ''''''' ▀▀     `█  ██║╚██╔╝██║██╔══╝  ██╔══╝     ██║       ╚██╔╝  ██║   ██║██║   ██║
  █████████  ▌       ▄▄████████─         ---------    L'▒▒▒ ██  ██║ ╚═╝ ██║███████╗███████╗   ██║        ██║   ╚██████╔╝╚██████╔╝
  ▀▀▀▀▀▀▀▀▀▀▀▀▀-     ▀▀▀▀▀▀▀▀▀▀       '╧╧╧╧╧╧╧╧╧`     ╚ ╧╧╧- ▀  ╚═╝     ╚═╝╚══════╝╚══════╝   ╚═╝        ╚═╝    ╚═════╝  ╚═════╝
  </pre>
</p>
