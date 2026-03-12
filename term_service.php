<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Terms of Service | Guidance Portal</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      box-sizing: border-box;
    }
    
    /* Custom animations */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    @keyframes float {
      0%, 100% {
        transform: translateY(0px);
      }
      50% {
        transform: translateY(-10px);
      }
    }
    
    @keyframes slideInLeft {
      from {
        opacity: 0;
        transform: translateX(-50px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }
    
    @keyframes slideInRight {
      from {
        opacity: 0;
        transform: translateX(50px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }
    
    @keyframes pulse {
      0%, 100% {
        transform: scale(1);
      }
      50% {
        transform: scale(1.05);
      }
    }
    
    .animate-fadeInUp {
      animation: fadeInUp 0.8s ease-out;
    }
    
    .animate-float {
      animation: float 3s ease-in-out infinite;
    }
    
    .animate-slideInLeft {
      animation: slideInLeft 0.8s ease-out;
    }
    
    .animate-slideInRight {
      animation: slideInRight 0.8s ease-out;
    }
    
    .animate-pulse-custom {
      animation: pulse 2s ease-in-out infinite;
    }
    
    /* Gradient backgrounds */
    .gradient-bg {
      background: linear-gradient(135deg, #3b82f6 0%, #1e40af 50%, #1e3a8a 100%);
    }
    
    .gradient-text {
      background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    
    .guidance-gradient {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .terms-gradient {
      background: linear-gradient(135deg, #6366f1 0%, #4f46e5 50%, #4338ca 100%);
    }
    
    /* Hover effects */
    .hover-lift {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-lift:hover {
      transform: translateY(-8px);
      box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    }
    
    /* Card hover effects */
    .card-hover {
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }
    
    .card-hover::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
      transition: left 0.5s;
    }
    
    .card-hover:hover::before {
      left: 100%;
    }
    
    /* Mobile menu animation */
    .mobile-menu {
      transform: translateX(-100%);
      transition: transform 0.3s ease;
    }
    .mobile-menu.active {
      transform: translateX(0);
    }
    
    /* Section icons */
    .section-icon {
      background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    }
    
    /* Smooth scroll behavior */
    html {
      scroll-behavior: smooth;
    }
    
    /* Custom scrollbar */
    ::-webkit-scrollbar {
      width: 8px;
    }
    
    ::-webkit-scrollbar-track {
      background: #f1f5f9;
    }
    
    ::-webkit-scrollbar-thumb {
      background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
      border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
      background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
    }
    
    /* List styling */
    .terms-list {
      counter-reset: section-counter;
    }
    
    .terms-list > li {
      counter-increment: section-counter;
      position: relative;
      padding-left: 3rem;
      margin-bottom: 2rem;
    }
    
    .terms-list > li::before {
      content: counter(section-counter);
      position: absolute;
      left: 0;
      top: 0;
      width: 2rem;
      height: 2rem;
      background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      font-size: 0.875rem;
    }
    
    /* Subsection styling */
    .subsection-list {
      counter-reset: subsection-counter;
    }
    
    .subsection-list > li {
      counter-increment: subsection-counter;
      position: relative;
      padding-left: 2rem;
      margin-bottom: 0.75rem;
    }
    
    .subsection-list > li::before {
      content: counter(section-counter) "." counter(subsection-counter);
      position: absolute;
      left: 0;
      top: 0;
      color: #6366f1;
      font-weight: 600;
      font-size: 0.875rem;
    }
    
    /* Highlight boxes */
    .highlight-box {
      border-left: 4px solid #6366f1;
      background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    }
    
    .warning-box {
      border-left: 4px solid #f59e0b;
      background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
    }
    
    .danger-box {
      border-left: 4px solid #ef4444;
      background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%);
    }
    
    /* Table of contents */
    .toc-link {
      transition: all 0.3s ease;
      border-left: 3px solid transparent;
    }
    
    .toc-link:hover {
      border-left-color: #6366f1;
      background: #f8fafc;
      transform: translateX(4px);
    }
    
    .toc-link.active {
      border-left-color: #6366f1;
      background: #f0f9ff;
      color: #6366f1;
    }
  </style>
</head>
<body class="font-sans text-gray-800 bg-gray-50">

  <!-- Header/Navbar -->
  <header class="bg-white/95 backdrop-blur-sm shadow-lg fixed top-0 left-0 w-full z-50">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
      <div class="flex items-center space-x-3">
        <div class="w-10 h-10 guidance-gradient rounded-xl flex items-center justify-center shadow-lg">
          <span class="text-white font-bold text-xl">🎯</span>
        </div>
        <h1 class="text-2xl font-bold gradient-text">GuidanceHub</h1>
      </div>
      
      <!-- Desktop Navigation -->
      <nav class="hidden md:flex space-x-8">
        <a href="home.php" class="hover:text-purple-600 transition-colors font-medium">Home</a>
        <a href="about.php" class="hover:text-purple-600 transition-colors font-medium">About</a>
        <a href="courses" class="hover:text-purple-600 transition-colors font-medium">Courses</a>
        <a href="contact.php" class="hover:text-purple-600 transition-colors font-medium">Contact</a>
      </nav>
      
      <!-- Mobile Menu Button -->
      <button id="mobileMenuBtn" class="md:hidden text-gray-600 hover:text-blue-600 transition-colors">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>
    </div>
    
    <!-- Mobile Menu -->
    <div id="mobileMenu" class="mobile-menu fixed top-0 left-0 w-full h-full bg-white z-40 md:hidden">
      <div class="flex flex-col p-6 space-y-6 mt-16">
        <a href="index.php" class="text-xl font-medium hover:text-blue-600 transition-colors">Home</a>
        <a href="about.php" class="text-xl font-medium hover:text-blue-600 transition-colors">About</a>
        <a href="courses.php" class="text-xl font-medium hover:text-blue-600 transition-colors">Courses</a>
        <a href="contact.php" class="text-xl font-medium hover:text-blue-600 transition-colors">Contact</a>
      </div>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="terms-gradient pt-32 pb-20 relative overflow-hidden">
    <!-- Background decorations -->
    <div class="absolute top-20 left-10 w-20 h-20 bg-white/10 rounded-full animate-float"></div>
    <div class="absolute bottom-20 right-10 w-32 h-32 bg-white/5 rounded-full animate-float" style="animation-delay: 1s;"></div>
    <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-white/5 rounded-full animate-pulse-custom"></div>
    
    <div class="container mx-auto px-6 text-center text-white relative z-10">
      <div class="max-w-4xl mx-auto animate-fadeInUp">
        <div class="inline-block bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium mb-6">
          📋 Legal Document
        </div>
        <h1 class="text-5xl lg:text-6xl font-bold mb-6 leading-tight">
          Terms of
          <span class="block text-yellow-300">Service</span>
        </h1>
        <p class="text-xl text-white/90 leading-relaxed max-w-2xl mx-auto mb-8">
          Please read these terms carefully before using the GuidanceHub portal. By accessing our services, you agree to be bound by these terms.
        </p>
        
        <div class="bg-white/10 backdrop-blur-sm p-4 rounded-xl max-w-md mx-auto">
          <p class="text-white/80 text-sm">
            <strong>Last Updated:</strong> December 2024<br>
            <strong>Effective Date:</strong> January 1, 2024
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Table of Contents -->
  <section class="py-12 -mt-10 relative z-10">
    <div class="container mx-auto px-6">
      <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-3xl p-8 shadow-xl border-2 border-gray-100">
          <h2 class="text-2xl font-bold gradient-text mb-6 text-center">Table of Contents</h2>
          <div class="grid md:grid-cols-2 gap-4">
            <a href="#acceptance" class="toc-link p-4 rounded-xl transition-all duration-300">
              <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center flex-shrink-0">
                  <span class="text-white font-bold text-sm">1</span>
                </div>
                <span class="font-medium text-gray-800">Acceptance of Terms</span>
              </div>
            </a>
            <a href="#user-responsibilities" class="toc-link p-4 rounded-xl transition-all duration-300">
              <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center flex-shrink-0">
                  <span class="text-white font-bold text-sm">2</span>
                </div>
                <span class="font-medium text-gray-800">User Responsibilities</span>
              </div>
            </a>
            <a href="#prohibited-use" class="toc-link p-4 rounded-xl transition-all duration-300">
              <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center flex-shrink-0">
                  <span class="text-white font-bold text-sm">3</span>
                </div>
                <span class="font-medium text-gray-800">Prohibited Use</span>
              </div>
            </a>
            <a href="#account-suspension" class="toc-link p-4 rounded-xl transition-all duration-300">
              <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center flex-shrink-0">
                  <span class="text-white font-bold text-sm">4</span>
                </div>
                <span class="font-medium text-gray-800">Account Suspension</span>
              </div>
            </a>
            <a href="#privacy-data" class="toc-link p-4 rounded-xl transition-all duration-300">
              <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center flex-shrink-0">
                  <span class="text-white font-bold text-sm">5</span>
                </div>
                <span class="font-medium text-gray-800">Privacy & Data Protection</span>
              </div>
            </a>
            <a href="#changes-terms" class="toc-link p-4 rounded-xl transition-all duration-300">
              <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center flex-shrink-0">
                  <span class="text-white font-bold text-sm">6</span>
                </div>
                <span class="font-medium text-gray-800">Changes to Terms</span>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Main Terms Content -->
  <main class="py-20">
    <div class="container mx-auto px-6">
      <div class="max-w-4xl mx-auto">
        
        <!-- Section 1: Acceptance of Terms -->
        <section id="acceptance" class="mb-16 animate-fadeInUp">
          <div class="bg-white rounded-3xl p-8 shadow-xl border-2 border-gray-100">
            <div class="flex items-center mb-8">
              <div class="section-icon w-16 h-16 rounded-2xl flex items-center justify-center mr-6">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
              <div>
                <h2 class="text-4xl font-bold gradient-text mb-2">1. Acceptance of Terms</h2>
                <p class="text-gray-600 text-lg">Agreement to use the GuidanceHub portal</p>
              </div>
            </div>
            
            <div class="space-y-6">
              <div class="highlight-box p-6 rounded-xl">
                <h3 class="text-xl font-semibold text-indigo-800 mb-4">By using this portal, you automatically agree to:</h3>
                <ul class="space-y-3 text-gray-700">
                  <li class="flex items-start space-x-3">
                    <div class="w-2 h-2 bg-indigo-500 rounded-full mt-2 flex-shrink-0"></div>
                    <span><strong>Follow all terms and conditions</strong> outlined in this document</span>
                  </li>
                  <li class="flex items-start space-x-3">
                    <div class="w-2 h-2 bg-indigo-500 rounded-full mt-2 flex-shrink-0"></div>
                    <span><strong>Comply with STI College policies</strong> and academic regulations</span>
                  </li>
                  <li class="flex items-start space-x-3">
                    <div class="w-2 h-2 bg-indigo-500 rounded-full mt-2 flex-shrink-0"></div>
                    <span><strong>Use the portal responsibly</strong> and for its intended educational purposes</span>
                  </li>
                  <li class="flex items-start space-x-3">
                    <div class="w-2 h-2 bg-indigo-500 rounded-full mt-2 flex-shrink-0"></div>
                    <span><strong>Accept any updates</strong> to these terms as they are published</span>
                  </li>
                </ul>
              </div>
              
              <div class="warning-box p-6 rounded-xl">
                <h4 class="text-lg font-semibold text-amber-800 mb-3">⚠️ Important Notice</h4>
                <p class="text-amber-700">
                  If you do not agree with any part of these terms, you must discontinue use of the GuidanceHub portal immediately. 
                  Continued use after changes to these terms constitutes acceptance of the new terms.
                </p>
              </div>
              
              <div class="bg-gray-50 p-6 rounded-xl">
                <h4 class="text-lg font-semibold text-gray-800 mb-3">📋 What This Means</h4>
                <ul class="space-y-2 text-gray-700 text-sm">
                  <li>• Creating an account means you've read and accepted these terms</li>
                  <li>• You're legally bound by these terms while using our services</li>
                  <li>• These terms protect both you and STI College</li>
                  <li>• Violations may result in account suspension or termination</li>
                </ul>
              </div>
            </div>
          </div>
        </section>

        <!-- Section 2: User Responsibilities -->
        <section id="user-responsibilities" class="mb-16 animate-fadeInUp">
          <div class="bg-white rounded-3xl p-8 shadow-xl border-2 border-gray-100">
            <div class="flex items-center mb-8">
              <div class="section-icon w-16 h-16 rounded-2xl flex items-center justify-center mr-6">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
              </div>
              <div>
                <h2 class="text-4xl font-bold gradient-text mb-2">2. User Responsibilities</h2>
                <p class="text-gray-600 text-lg">Your obligations as a portal user</p>
              </div>
            </div>
            
            <div class="space-y-6">
              <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-blue-50 p-6 rounded-xl border border-blue-200">
                  <h3 class="text-lg font-semibold text-blue-800 mb-4">📝 Account Information</h3>
                  <ul class="space-y-2 text-blue-700 text-sm">
                    <li>• Provide accurate and truthful personal information</li>
                    <li>• Use your real name and valid student ID number</li>
                    <li>• Keep your contact information up to date</li>
                    <li>• Verify your email address promptly</li>
                    <li>• Report any changes to your academic status</li>
                  </ul>
                </div>
                
                <div class="bg-green-50 p-6 rounded-xl border border-green-200">
                  <h3 class="text-lg font-semibold text-green-800 mb-4">🔐 Account Security</h3>
                  <ul class="space-y-2 text-green-700 text-sm">
                    <li>• Create a strong, unique password</li>
                    <li>• Keep your login credentials confidential</li>
                    <li>• Log out from shared or public computers</li>
                    <li>• Report suspicious account activity immediately</li>
                    <li>• Don't share your account with others</li>
                  </ul>
                </div>
                
                <div class="bg-purple-50 p-6 rounded-xl border border-purple-200">
                  <h3 class="text-lg font-semibold text-purple-800 mb-4">📅 Appointment Management</h3>
                  <ul class="space-y-2 text-purple-700 text-sm">
                    <li>• Book appointments honestly and in good faith</li>
                    <li>• Attend scheduled appointments on time</li>
                    <li>• Cancel appointments at least 4 hours in advance</li>
                    <li>• Provide accurate reasons for appointment requests</li>
                    <li>• Respect counselors' time and availability</li>
                  </ul>
                </div>
                
                <div class="bg-orange-50 p-6 rounded-xl border border-orange-200">
                  <h3 class="text-lg font-semibold text-orange-800 mb-4">💬 Communication Standards</h3>
                  <ul class="space-y-2 text-orange-700 text-sm">
                    <li>• Communicate respectfully with staff and counselors</li>
                    <li>• Use appropriate language in all interactions</li>
                    <li>• Respond to official communications promptly</li>
                    <li>• Follow proper channels for complaints or concerns</li>
                    <li>• Maintain confidentiality of sensitive information</li>
                  </ul>
                </div>
              </div>
              
              <div class="highlight-box p-6 rounded-xl">
                <h3 class="text-xl font-semibold text-indigo-800 mb-4">🎯 Academic Integrity</h3>
                <p class="text-indigo-700 mb-4">As a student using this portal, you must:</p>
                <div class="grid md:grid-cols-2 gap-4">
                  <ul class="space-y-2 text-indigo-700 text-sm">
                    <li>• Be honest in all assessments and evaluations</li>
                    <li>• Provide truthful information about your academic progress</li>
                    <li>• Report any technical issues or errors promptly</li>
                    <li>• Use the portal only for legitimate educational purposes</li>
                  </ul>
                  <ul class="space-y-2 text-indigo-700 text-sm">
                    <li>• Respect intellectual property and copyrights</li>
                    <li>• Follow STI College's academic honor code</li>
                    <li>• Maintain professional conduct in all interactions</li>
                    <li>• Support a positive learning environment</li>
                  </ul>
                </div>
              </div>
              
              <div class="bg-gray-50 p-6 rounded-xl">
                <h4 class="text-lg font-semibold text-gray-800 mb-3">✅ Compliance Checklist</h4>
                <div class="grid md:grid-cols-2 gap-4">
                  <div>
                    <h5 class="font-medium text-gray-700 mb-2">Before Using the Portal:</h5>
                    <ul class="space-y-1 text-gray-600 text-sm">
                      <li>□ Read and understand these terms</li>
                      <li>□ Verify your student status</li>
                      <li>□ Set up secure login credentials</li>
                      <li>□ Complete your profile information</li>
                    </ul>
                  </div>
                  <div>
                    <h5 class="font-medium text-gray-700 mb-2">While Using the Portal:</h5>
                    <ul class="space-y-1 text-gray-600 text-sm">
                      <li>□ Follow all posted guidelines</li>
                      <li>□ Respect system limitations</li>
                      <li>□ Report issues promptly</li>
                      <li>□ Maintain account security</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Section 3: Prohibited Use -->
        <section id="prohibited-use" class="mb-16 animate-fadeInUp">
          <div class="bg-white rounded-3xl p-8 shadow-xl border-2 border-gray-100">
            <div class="flex items-center mb-8">
              <div class="section-icon w-16 h-16 rounded-2xl flex items-center justify-center mr-6">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L5.636 5.636"></path>
                </svg>
              </div>
              <div>
                <h2 class="text-4xl font-bold gradient-text mb-2">3. Prohibited Use</h2>
                <p class="text-gray-600 text-lg">Activities that are strictly forbidden</p>
              </div>
            </div>
            
            <div class="space-y-6">
              <div class="danger-box p-6 rounded-xl">
                <h3 class="text-xl font-semibold text-red-800 mb-4">🚫 Strictly Prohibited Activities</h3>
                <p class="text-red-700 mb-4">The following activities will result in immediate account suspension:</p>
              </div>
              
              <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-red-50 p-6 rounded-xl border border-red-200">
                  <h4 class="text-lg font-semibold text-red-800 mb-4">📧 Spam & Abuse</h4>
                  <ul class="space-y-2 text-red-700 text-sm">
                    <li>• Sending spam messages or emails</li>
                    <li>• Creating multiple fake accounts</li>
                    <li>• Automated or bot-generated activities</li>
                    <li>• Excessive or unnecessary system requests</li>
                    <li>• Flooding the system with fake data</li>
                  </ul>
                </div>
                
                <div class="bg-red-50 p-6 rounded-xl border border-red-200">
                  <h4 class="text-lg font-semibold text-red-800 mb-4">📅 Fake Bookings</h4>
                  <ul class="space-y-2 text-red-700 text-sm">
                    <li>• Booking appointments with no intention to attend</li>
                    <li>• Making multiple bookings for the same time slot</li>
                    <li>• Using false information in appointment requests</li>
                    <li>• Booking on behalf of others without permission</li>
                    <li>• Repeatedly canceling appointments last minute</li>
                  </ul>
                </div>
                
                <div class="bg-red-50 p-6 rounded-xl border border-red-200">
                  <h4 class="text-lg font-semibold text-red-800 mb-4">💬 Offensive Content</h4>
                  <ul class="space-y-2 text-red-700 text-sm">
                    <li>• Harassment, bullying, or threatening language</li>
                    <li>• Discriminatory or hate speech</li>
                    <li>• Sexually explicit or inappropriate content</li>
                    <li>• Profanity or vulgar language</li>
                    <li>• Content that violates others' privacy</li>
                  </ul>
                </div>
                
                <div class="bg-red-50 p-6 rounded-xl border border-red-200">
                  <h4 class="text-lg font-semibold text-red-800 mb-4">🔓 Security Violations</h4>
                  <ul class="space-y-2 text-red-700 text-sm">
                    <li>• Attempting to hack or breach system security</li>
                    <li>• Sharing login credentials with unauthorized users</li>
                    <li>• Accessing other users' accounts or data</li>
                    <li>• Attempting to bypass security measures</li>
                    <li>• Installing malicious software or scripts</li>
                  </ul>
                </div>
                
                <div class="bg-red-50 p-6 rounded-xl border border-red-200">
                  <h4 class="text-lg font-semibold text-red-800 mb-4">📋 False Information</h4>
                  <ul class="space-y-2 text-red-700 text-sm">
                    <li>• Providing fake personal or academic information</li>
                    <li>• Impersonating other students or staff members</li>
                    <li>• Submitting fraudulent documents or records</li>
                    <li>• Lying about your identity or student status</li>
                    <li>• Creating accounts with false credentials</li>
                  </ul>
                </div>
                
                <div class="bg-red-50 p-6 rounded-xl border border-red-200">
                  <h4 class="text-lg font-semibold text-red-800 mb-4">⚖️ Legal Violations</h4>
                  <ul class="space-y-2 text-red-700 text-sm">
                    <li>• Any illegal activities or content</li>
                    <li>• Copyright or trademark infringement</li>
                    <li>• Violation of privacy laws</li>
                    <li>• Activities that could harm STI's reputation</li>
                    <li>• Breach of confidentiality agreements</li>
                  </ul>
                </div>
              </div>
              
              <div class="warning-box p-6 rounded-xl">
                <h4 class="text-lg font-semibold text-amber-800 mb-3">⚠️ Additional Restrictions</h4>
                <div class="grid md:grid-cols-2 gap-4">
                  <div>
                    <h5 class="font-medium text-amber-700 mb-2">System Misuse:</h5>
                    <ul class="space-y-1 text-amber-700 text-sm">
                      <li>• Overloading servers with excessive requests</li>
                      <li>• Attempting to reverse engineer the system</li>
                      <li>• Using the portal for commercial purposes</li>
                      <li>• Interfering with other users' access</li>
                    </ul>
                  </div>
                  <div>
                    <h5 class="font-medium text-amber-700 mb-2">Content Violations:</h5>
                    <ul class="space-y-1 text-amber-700 text-sm">
                      <li>• Posting irrelevant or off-topic content</li>
                      <li>• Sharing confidential counseling information</li>
                      <li>• Distributing unauthorized materials</li>
                      <li>• Promoting non-STI services or products</li>
                    </ul>
                  </div>
                </div>
              </div>
              
              <div class="bg-blue-50 p-6 rounded-xl border border-blue-200">
                <h4 class="text-lg font-semibold text-blue-800 mb-3">📞 Reporting Violations</h4>
                <p class="text-blue-700 mb-3">If you witness or experience any prohibited activities:</p>
                <div class="grid md:grid-cols-3 gap-4">
                  <div class="text-center">
                    <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mx-auto mb-2">
                      <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                      </svg>
                    </div>
                    <p class="text-blue-700 text-sm font-medium">Email Report</p>
                    <p class="text-blue-600 text-xs">violations@sti.edu.ph</p>
                  </div>
                  <div class="text-center">
                    <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mx-auto mb-2">
                      <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                      </svg>
                    </div>
                    <p class="text-blue-700 text-sm font-medium">Phone Report</p>
                    <p class="text-blue-600 text-xs">(02) 1234-5681</p>
                  </div>
                  <div class="text-center">
                    <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mx-auto mb-2">
                      <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                      </svg>
                    </div>
                    <p class="text-blue-700 text-sm font-medium">Emergency</p>
                    <p class="text-blue-600 text-xs">Campus Security</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Section 4: Account Suspension -->
        <section id="account-suspension" class="mb-16 animate-fadeInUp">
          <div class="bg-white rounded-3xl p-8 shadow-xl border-2 border-gray-100">
            <div class="flex items-center mb-8">
              <div class="section-icon w-16 h-16 rounded-2xl flex items-center justify-center mr-6">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
              </div>
              <div>
                <h2 class="text-4xl font-bold gradient-text mb-2">4. Account Suspension</h2>
                <p class="text-gray-600 text-lg">Consequences for policy violations</p>
              </div>
            </div>
            
            <div class="space-y-6">
              <div class="danger-box p-6 rounded-xl">
                <h3 class="text-xl font-semibold text-red-800 mb-4">⚖️ Violation Consequences</h3>
                <p class="text-red-700 mb-4">STI College reserves the right to suspend or terminate accounts for policy violations. The severity of consequences depends on the nature and frequency of violations.</p>
              </div>
              
              <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-yellow-50 p-6 rounded-xl border border-yellow-200">
                  <div class="text-center mb-4">
                    <div class="w-16 h-16 bg-yellow-500 rounded-2xl flex items-center justify-center mx-auto mb-3">
                      <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                      </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-yellow-800">First Warning</h4>
                  </div>
                  <ul class="space-y-2 text-yellow-700 text-sm">
                    <li>• Email notification of violation</li>
                    <li>• Explanation of policy breach</li>
                    <li>• Opportunity to correct behavior</li>
                    <li>• No service interruption</li>
                    <li>• Warning recorded in account</li>
                  </ul>
                  <div class="mt-4 p-3 bg-yellow-100 rounded-lg">
                    <p class="text-yellow-800 text-xs font-medium">Duration: Permanent record</p>
                  </div>
                </div>
                
                <div class="bg-orange-50 p-6 rounded-xl border border-orange-200">
                  <div class="text-center mb-4">
                    <div class="w-16 h-16 bg-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-3">
                      <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L5.636 5.636"></path>
                      </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-orange-800">Temporary Suspension</h4>
                  </div>
                  <ul class="space-y-2 text-orange-700 text-sm">
                    <li>• Account access temporarily blocked</li>
                    <li>• Cannot book new appointments</li>
                    <li>• Existing appointments may be canceled</li>
                    <li>• Must complete remedial training</li>
                    <li>• Review meeting required</li>
                  </ul>
                  <div class="mt-4 p-3 bg-orange-100 rounded-lg">
                    <p class="text-orange-800 text-xs font-medium">Duration: 1-30 days</p>
                  </div>
                </div>
                
                <div class="bg-red-50 p-6 rounded-xl border border-red-200">
                  <div class="text-center mb-4">
                    <div class="w-16 h-16 bg-red-500 rounded-2xl flex items-center justify-center mx-auto mb-3">
                      <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-red-800">Permanent Termination</h4>
                  </div>
                  <ul class="space-y-2 text-red-700 text-sm">
                    <li>• Account permanently disabled</li>
                    <li>• All data and appointments removed</li>
                    <li>• Banned from creating new accounts</li>
                    <li>• May affect academic standing</li>
                    <li>• Legal action may be pursued</li>
                  </ul>
                  <div class="mt-4 p-3 bg-red-100 rounded-lg">
                    <p class="text-red-800 text-xs font-medium">Duration: Permanent</p>
                  </div>
                </div>
              </div>
              
              <div class="bg-gray-50 p-6 rounded-xl">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">📋 Suspension Process</h4>
                <div class="space-y-4">
                  <div class="flex items-start space-x-4">
                    <div class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                      <span class="text-white font-bold text-sm">1</span>
                    </div>
                    <div>
                      <h5 class="font-semibold text-gray-800">Investigation</h5>
                      <p class="text-gray-600 text-sm">All reported violations are thoroughly investigated by our compliance team.</p>
                    </div>
                  </div>
                  
                  <div class="flex items-start space-x-4">
                    <div class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                      <span class="text-white font-bold text-sm">2</span>
                    </div>
                    <div>
                      <h5 class="font-semibold text-gray-800">Notification</h5>
                      <p class="text-gray-600 text-sm">You'll receive an email explaining the violation and proposed consequences.</p>
                    </div>
                  </div>
                  
                  <div class="flex items-start space-x-4">
                    <div class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                      <span class="text-white font-bold text-sm">3</span>
                    </div>
                    <div>
                      <h5 class="font-semibold text-gray-800">Response Period</h5>
                      <p class="text-gray-600 text-sm">You have 5 business days to respond or appeal the decision.</p>
                    </div>
                  </div>
                  
                  <div class="flex items-start space-x-4">
                    <div class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                      <span class="text-white font-bold text-sm">4</span>
                    </div>
                    <div>
                      <h5 class="font-semibold text-gray-800">Final Decision</h5>
                      <p class="text-gray-600 text-sm">After review, the final decision is implemented and communicated.</p>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="highlight-box p-6 rounded-xl">
                <h4 class="text-lg font-semibold text-indigo-800 mb-3">🔄 Appeal Process</h4>
                <p class="text-indigo-700 mb-4">If you believe your account was suspended unfairly, you can appeal:</p>
                <div class="grid md:grid-cols-2 gap-4">
                  <div>
                    <h5 class="font-medium text-indigo-700 mb-2">How to Appeal:</h5>
                    <ul class="space-y-1 text-indigo-700 text-sm">
                      <li>• Email appeals@sti.edu.ph within 5 days</li>
                      <li>• Include your student ID and case details</li>
                      <li>• Provide evidence supporting your case</li>
                      <li>• Request a review meeting if needed</li>
                    </ul>
                  </div>
                  <div>
                    <h5 class="font-medium text-indigo-700 mb-2">Appeal Review:</h5>
                    <ul class="space-y-1 text-indigo-700 text-sm">
                      <li>• Independent review committee assessment</li>
                      <li>• Response within 10 business days</li>
                      <li>• Decision is final and binding</li>
                      <li>• Account restored if appeal successful</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Section 5: Privacy & Data Protection -->
        <section id="privacy-data" class="mb-16 animate-fadeInUp">
          <div class="bg-white rounded-3xl p-8 shadow-xl border-2 border-gray-100">
            <div class="flex items-center mb-8">
              <div class="section-icon w-16 h-16 rounded-2xl flex items-center justify-center mr-6">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
              </div>
              <div>
                <h2 class="text-4xl font-bold gradient-text mb-2">5. Privacy & Data Protection</h2>
                <p class="text-gray-600 text-lg">How we protect and use your information</p>
              </div>
            </div>
            
            <div class="space-y-6">
              <div class="highlight-box p-6 rounded-xl">
                <h3 class="text-xl font-semibold text-indigo-800 mb-4">🔐 Data Protection Commitment</h3>
                <p class="text-indigo-700 mb-4">STI College is committed to protecting your personal information and maintaining your privacy while using the GuidanceHub portal.</p>
              </div>
              
              <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-green-50 p-6 rounded-xl border border-green-200">
                  <h4 class="text-lg font-semibold text-green-800 mb-4">📊 Information We Collect</h4>
                  <ul class="space-y-2 text-green-700 text-sm">
                    <li>• Personal identification (name, student ID)</li>
                    <li>• Contact information (email, phone)</li>
                    <li>• Academic information (program, year level)</li>
                    <li>• Appointment history and preferences</li>
                    <li>• Assessment results and counseling notes</li>
                    <li>• System usage and activity logs</li>
                  </ul>
                </div>
                
                <div class="bg-blue-50 p-6 rounded-xl border border-blue-200">
                  <h4 class="text-lg font-semibold text-blue-800 mb-4">🎯 How We Use Your Data</h4>
                  <ul class="space-y-2 text-blue-700 text-sm">
                    <li>• Provide guidance and counseling services</li>
                    <li>• Schedule and manage appointments</li>
                    <li>• Track academic progress and goals</li>
                    <li>• Improve portal functionality</li>
                    <li>• Generate reports for academic planning</li>
                    <li>• Ensure system security and compliance</li>
                  </ul>
                </div>
                
                <div class="bg-purple-50 p-6 rounded-xl border border-purple-200">
                  <h4 class="text-lg font-semibold text-purple-800 mb-4">🔒 Data Security Measures</h4>
                  <ul class="space-y-2 text-purple-700 text-sm">
                    <li>• Encrypted data transmission (SSL/TLS)</li>
                    <li>• Secure database storage</li>
                    <li>• Regular security audits and updates</li>
                    <li>• Access controls and authentication</li>
                    <li>• Staff training on data protection</li>
                    <li>• Incident response procedures</li>
                  </ul>
                </div>
                
                <div class="bg-orange-50 p-6 rounded-xl border border-orange-200">
                  <h4 class="text-lg font-semibold text-orange-800 mb-4">👥 Data Sharing Policy</h4>
                  <ul class="space-y-2 text-orange-700 text-sm">
                    <li>• Limited to authorized STI staff only</li>
                    <li>• Shared with counselors for service delivery</li>
                    <li>• Academic advisors for progress tracking</li>
                    <li>• Emergency contacts in crisis situations</li>
                    <li>• Legal authorities when required by law</li>
                    <li>• Never sold to third parties</li>
                  </ul>
                </div>
              </div>
              
              <div class="bg-gray-50 p-6 rounded-xl">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">👤 Your Privacy Rights</h4>
                <div class="grid md:grid-cols-2 gap-6">
                  <div>
                    <h5 class="font-medium text-gray-700 mb-3">Data Access Rights:</h5>
                    <ul class="space-y-2 text-gray-600 text-sm">
                      <li>• Request a copy of your personal data</li>
                      <li>• View your appointment and assessment history</li>
                      <li>• Access your account activity logs</li>
                      <li>• Download your data in portable format</li>
                    </ul>
                  </div>
                  <div>
                    <h5 class="font-medium text-gray-700 mb-3">Data Control Rights:</h5>
                    <ul class="space-y-2 text-gray-600 text-sm">
                      <li>• Update or correct your information</li>
                      <li>• Request deletion of certain data</li>
                      <li>• Opt-out of non-essential communications</li>
                      <li>• Restrict processing for specific purposes</li>
                    </ul>
                  </div>
                </div>
                
                <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                  <p class="text-blue-800 text-sm">
                    <strong>To exercise your privacy rights:</strong> Contact our Data Protection Officer at privacy@sti.edu.ph or call (02) 1234-5682
                  </p>
                </div>
              </div>
              
              <div class="warning-box p-6 rounded-xl">
                <h4 class="text-lg font-semibold text-amber-800 mb-3">⚠️ Data Retention Policy</h4>
                <div class="space-y-3">
                  <p class="text-amber-700 text-sm">We retain your data for the following periods:</p>
                  <div class="grid md:grid-cols-2 gap-4">
                    <div>
                      <h5 class="font-medium text-amber-700 mb-2">Active Students:</h5>
                      <ul class="space-y-1 text-amber-700 text-sm">
                        <li>• Account data: Duration of enrollment + 2 years</li>
                        <li>• Counseling records: 7 years after graduation</li>
                        <li>• Assessment results: 5 years after completion</li>
                      </ul>
                    </div>
                    <div>
                      <h5 class="font-medium text-amber-700 mb-2">Inactive/Graduated:</h5>
                      <ul class="space-y-1 text-amber-700 text-sm">
                        <li>• Basic records: 10 years after last activity</li>
                        <li>• Sensitive data: Deleted after 2 years</li>
                        <li>• System logs: 1 year for security purposes</li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Section 6: Changes to Terms -->
        <section id="changes-terms" class="mb-16 animate-fadeInUp">
          <div class="bg-white rounded-3xl p-8 shadow-xl border-2 border-gray-100">
            <div class="flex items-center mb-8">
              <div class="section-icon w-16 h-16 rounded-2xl flex items-center justify-center mr-6">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
              </div>
              <div>
                <h2 class="text-4xl font-bold gradient-text mb-2">6. Changes to Terms</h2>
                <p class="text-gray-600 text-lg">How we update and communicate changes</p>
              </div>
            </div>
            
            <div class="space-y-6">
              <div class="highlight-box p-6 rounded-xl">
                <h3 class="text-xl font-semibold text-indigo-800 mb-4">📝 Terms Update Policy</h3>
                <p class="text-indigo-700 mb-4">STI College reserves the right to modify these Terms of Service at any time to reflect changes in our services, legal requirements, or operational needs.</p>
              </div>
              
              <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-blue-50 p-6 rounded-xl border border-blue-200">
                  <h4 class="text-lg font-semibold text-blue-800 mb-4">🔄 When We Update Terms</h4>
                  <ul class="space-y-2 text-blue-700 text-sm">
                    <li>• Changes in portal functionality or features</li>
                    <li>• Updates to legal or regulatory requirements</li>
                    <li>• Modifications to our privacy practices</li>
                    <li>• Changes in STI College policies</li>
                    <li>• Security enhancements or requirements</li>
                    <li>• User feedback and improvement needs</li>
                  </ul>
                </div>
                
                <div class="bg-green-50 p-6 rounded-xl border border-green-200">
                  <h4 class="text-lg font-semibold text-green-800 mb-4">📢 How We Notify You</h4>
                  <ul class="space-y-2 text-green-700 text-sm">
                    <li>• Email notification to registered address</li>
                    <li>• Portal banner announcement</li>
                    <li>• Updated "Last Modified" date on this page</li>
                    <li>• SMS notification for major changes</li>
                    <li>• Posted notice on STI website</li>
                    <li>• In-app notification upon login</li>
                  </ul>
                </div>
              </div>
              
              <div class="bg-gray-50 p-6 rounded-xl">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">⏰ Timeline for Changes</h4>
                <div class="space-y-4">
                  <div class="flex items-start space-x-4">
                    <div class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                      <span class="text-white font-bold text-sm">1</span>
                    </div>
                    <div>
                      <h5 class="font-semibold text-gray-800">30 Days Before (Major Changes)</h5>
                      <p class="text-gray-600 text-sm">Significant policy changes that affect your rights or how we handle your data.</p>
                    </div>
                  </div>
                  
                  <div class="flex items-start space-x-4">
                    <div class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                      <span class="text-white font-bold text-sm">2</span>
                    </div>
                    <div>
                      <h5 class="font-semibold text-gray-800">7 Days Before (Minor Changes)</h5>
                      <p class="text-gray-600 text-sm">Small updates, clarifications, or administrative changes.</p>
                    </div>
                  </div>
                  
                  <div class="flex items-start space-x-4">
                    <div class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                      <span class="text-white font-bold text-sm">3</span>
                    </div>
                    <div>
                      <h5 class="font-semibold text-gray-800">Immediate (Emergency Changes)</h5>
                      <p class="text-gray-600 text-sm">Critical security updates or legal compliance requirements.</p>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="warning-box p-6 rounded-xl">
                <h4 class="text-lg font-semibold text-amber-800 mb-3">⚠️ Your Response Options</h4>
                <p class="text-amber-700 mb-4">When we notify you of changes, you have several options:</p>
                <div class="grid md:grid-cols-2 gap-4">
                  <div>
                    <h5 class="font-medium text-amber-700 mb-2">Accept Changes:</h5>
                    <ul class="space-y-1 text-amber-700 text-sm">
                      <li>• Continue using the portal normally</li>
                      <li>• No action required on your part</li>
                      <li>• Automatic acceptance after effective date</li>
                    </ul>
                  </div>
                  <div>
                    <h5 class="font-medium text-amber-700 mb-2">Reject Changes:</h5>
                    <ul class="space-y-1 text-amber-700 text-sm">
                      <li>• Contact us within the notice period</li>
                      <li>• Request account closure if desired</li>
                      <li>• Download your data before leaving</li>
                    </ul>
                  </div>
                </div>
              </div>
              
              <div class="bg-blue-50 p-6 rounded-xl border border-blue-200">
                <h4 class="text-lg font-semibold text-blue-800 mb-3">📋 Version History</h4>
                <p class="text-blue-700 mb-4">We maintain a record of all changes to these terms:</p>
                <div class="space-y-3">
                  <div class="flex justify-between items-center p-3 bg-white rounded-lg">
                    <div>
                      <p class="font-medium text-blue-800">Version 2.1</p>
                      <p class="text-blue-600 text-sm">Current version - Updated privacy section</p>
                    </div>
                    <span class="text-blue-600 text-sm">Dec 2024</span>
                  </div>
                  <div class="flex justify-between items-center p-3 bg-white rounded-lg">
                    <div>
                      <p class="font-medium text-blue-800">Version 2.0</p>
                      <p class="text-blue-600 text-sm">Added data protection policies</p>
                    </div>
                    <span class="text-blue-600 text-sm">Sep 2024</span>
                  </div>
                  <div class="flex justify-between items-center p-3 bg-white rounded-lg">
                    <div>
                      <p class="font-medium text-blue-800">Version 1.0</p>
                      <p class="text-blue-600 text-sm">Initial terms of service</p>
                    </div>
                    <span class="text-blue-600 text-sm">Jan 2024</span>
                  </div>
                </div>
                
                <div class="mt-4 p-3 bg-blue-100 rounded-lg">
                  <p class="text-blue-800 text-sm">
                    <strong>View Full History:</strong> Contact legal@sti.edu.ph for complete version history and change logs.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Contact & Support -->
        <section class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-3xl p-8 text-white text-center animate-fadeInUp">
          <h3 class="text-3xl font-bold mb-4">Questions About These Terms?</h3>
          <p class="text-xl mb-6 text-white/90">
            Our legal and support teams are here to help clarify any questions about these terms of service.
          </p>
          
          <div class="grid md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white/10 backdrop-blur-sm p-6 rounded-2xl">
              <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
              </div>
              <h4 class="font-semibold mb-2">Legal Questions</h4>
              <p class="text-white/80 text-sm">legal@sti.edu.ph</p>
              <p class="text-white/60 text-xs mt-1">Terms & policy inquiries</p>
            </div>
            
            <div class="bg-white/10 backdrop-blur-sm p-6 rounded-2xl">
              <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
              </div>
              <h4 class="font-semibold mb-2">Technical Support</h4>
              <p class="text-white/80 text-sm">support@sti.edu.ph</p>
              <p class="text-white/60 text-xs mt-1">Portal & account issues</p>
            </div>
            
            <div class="bg-white/10 backdrop-blur-sm p-6 rounded-2xl">
              <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
              </div>
              <h4 class="font-semibold mb-2">Privacy Officer</h4>
              <p class="text-white/80 text-sm">privacy@sti.edu.ph</p>
              <p class="text-white/60 text-xs mt-1">Data protection concerns</p>
            </div>
          </div>
          
          <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="contact.php" class="bg-white text-indigo-600 px-8 py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
              Contact Legal Team 📞
            </a>
            <a href="help-center.php" class="border-2 border-white text-white px-8 py-4 rounded-xl font-semibold hover:bg-white hover:text-indigo-600 transition-all duration-300">
              Visit Help Center 🆘
            </a>
          </div>
          
          <div class="mt-8 p-4 bg-white/10 backdrop-blur-sm rounded-xl">
            <p class="text-white/80 text-sm">
              <strong>Last Updated:</strong> December 15, 2024 | 
              <strong>Effective Date:</strong> January 1, 2024 | 
              <strong>Version:</strong> 2.1
            </p>
          </div>
        </section>
      </div>
    </div>
  </main>

  <script>
    // Mobile menu functionality
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');

    mobileMenuBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('active');
    });

    // Close mobile menu when clicking on links
    const mobileLinks = mobileMenu.querySelectorAll('a');
    mobileLinks.forEach(link => {
      link.addEventListener('click', () => {
        mobileMenu.classList.remove('active');
      });
    });

    // Header scroll effect
    window.addEventListener('scroll', () => {
      const header = document.querySelector('header');
      if (window.scrollY > 100) {
        header.classList.add('shadow-xl');
      } else {
        header.classList.remove('shadow-xl');
      }
    });

    // Table of contents active link tracking
    const sections = document.querySelectorAll('section[id]');
    const tocLinks = document.querySelectorAll('.toc-link');

    function updateActiveLink() {
      let current = '';
      sections.forEach(section => {
        const sectionTop = section.offsetTop - 150;
        if (window.scrollY >= sectionTop) {
          current = section.getAttribute('id');
        }
      });

      tocLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === `#${current}`) {
          link.classList.add('active');
        }
      });
    }

    window.addEventListener('scroll', updateActiveLink);

    // Intersection Observer for animations
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.opacity = '1';
          entry.target.style.transform = 'translateY(0) translateX(0)';
        }
      });
    }, observerOptions);

    // Observe elements for animation
    document.querySelectorAll('.animate-fadeInUp, .animate-slideInLeft, .animate-slideInRight').forEach(el => {
      el.style.opacity = '0';
      if (el.classList.contains('animate-slideInLeft')) {
        el.style.transform = 'translateX(-50px)';
      } else if (el.classList.contains('animate-slideInRight')) {
        el.style.transform = 'translateX(50px)';
      } else {
        el.style.transform = 'translateY(30px)';
      }
      observer.observe(el);
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          const headerHeight = 100;
          const targetPosition = target.offsetTop - headerHeight;
          
          window.scrollTo({
            top: targetPosition,
            behavior: 'smooth'
          });
        }
      });
    });

    // Print functionality
    function printTerms() {
      window.print();
    }

    // Copy link functionality
    function copyLink(section) {
      const url = window.location.origin + window.location.pathname + '#' + section;
      navigator.clipboard.writeText(url).then(() => {
        // Show success message
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
        toast.textContent = 'Link copied to clipboard!';
        document.body.appendChild(toast);
        
        setTimeout(() => {
          document.body.removeChild(toast);
        }, 3000);
      });
    }
  </script>

<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'986257fe772b0dcd',t:'MTc1OTA1MzEwMi4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>

