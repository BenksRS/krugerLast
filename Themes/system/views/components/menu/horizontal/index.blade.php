<!-- ========== Topbar Start ========== -->
<div class="topnav">
	<div class="container-fluid">
		<nav class="navbar navbar-light navbar-expand-lg topnav-menu">
			
			<div class="collapse navbar-collapse" id="topnav-menu-content">
				
				<livewire:menu::show-menu/>
{{--				<ul class="navbar-nav">--}}
{{--					--}}
{{--					--}}{{--					<li class="nav-item dropdown">--}}
{{--					--}}{{--						<a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboard" role="button"--}}
{{--					--}}{{--						>--}}
{{--					--}}{{--							<i class="bx bx-home-circle me-2"></i><span key="t-dashboards">Dashboards</span> <div class="arrow-down"></div>--}}
{{--					--}}{{--						</a>--}}
{{--					--}}{{--						<div class="dropdown-menu" aria-labelledby="topnav-dashboard">--}}
{{--					--}}
{{--					--}}{{--							<a href="index.html" class="dropdown-item" key="t-default">Default2</a>--}}
{{--					--}}{{--							<a href="dashboard-saas.html" class="dropdown-item" key="t-saas">Saas</a>--}}
{{--					--}}{{--							<a href="dashboard-crypto.html" class="dropdown-item" key="t-crypto">Crypto</a>--}}
{{--					--}}{{--							<a href="dashboard-blog.html" class="dropdown-item" key="t-blog">Blog</a>--}}
{{--					--}}{{--						</div>--}}
{{--					--}}{{--					</li>--}}
{{--					<li class="nav-item dropdown">--}}
{{--						<a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboard" role="button"--}}
{{--						> <i class="bx bx-home-circle me-2"></i><span key="t-dashboards">Dashboard</span>--}}
{{--							<div class="arrow-down"></div>--}}
{{--						</a>--}}
{{--						<div class="dropdown-menu" aria-labelledby="topnav-dashboard">--}}
{{--							<a href="{{ url('/dashboard') }}" class="dropdown-item" key="t-default">Home</a>--}}
{{--							<a href="{{ url('/dashboard/list/open') }}" class="dropdown-item" key="t-default">Open Jobs</a>--}}
{{--							<a href="{{ url('/dashboard/list/readytobill') }}" class="dropdown-item" key="t-default">Ready to bill</a>--}}
{{--						</div>--}}
{{--					</li>--}}
{{--					<li class="nav-item dropdown">--}}
{{--						<a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboard" role="button"--}}
{{--						> <i class="bx bx-file me-2"></i><span key="t-dashboards">Assignments</span>--}}
{{--							<div class="arrow-down"></div>--}}
{{--						</a>--}}
{{--						<div class="dropdown-menu" aria-labelledby="topnav-dashboard">--}}
{{--							<a href="{{ url('/assignments/new') }}" class="dropdown-item" key="t-default">New</a>--}}
{{--							<a href="{{ url('/assignments') }}" class="dropdown-item" key="t-default">List</a>--}}
{{--						</div>--}}
{{--					</li>--}}
{{--					<li class="nav-item dropdown">--}}
{{--						<a class="nav-link dropdown-toggle arrow-none" target="_blank" href="{{ url('/schedulling/') }}" id="topnav-dashboard" role="button"--}}
{{--						> <i class="bx bx-grid me-2"></i> Scheduling </a>--}}
{{--					</li>--}}
{{--					<li class="nav-item dropdown">--}}
{{--						<a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboard" role="button"--}}
{{--						> <i class="bx bxs-business me-2"></i><span key="t-dashboards">Referral</span>--}}
{{--							<div class="arrow-down"></div>--}}
{{--						</a>--}}
{{--						<div class="dropdown-menu" aria-labelledby="topnav-dashboard">--}}
{{--							<a href="{{ url('/referrals/new') }}" class="dropdown-item" key="t-default">New</a>--}}
{{--							<a href="{{ url('/referrals') }}" class="dropdown-item" key="t-default">List All </a>--}}
{{--							<a href="{{ url('/referrals/mylist') }}" class="dropdown-item" key="t-default">My List </a>--}}
{{--						</div>--}}
{{--					</li>--}}
{{--					<li class="nav-item dropdown">--}}
{{--						<a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboard" role="button"--}}
{{--						> <i class="bx bxs-business me-2"></i><span key="t-dashboards">Prospects</span>--}}
{{--							<div class="arrow-down"></div>--}}
{{--						</a>--}}
{{--						<div class="dropdown-menu" aria-labelledby="topnav-dashboard">--}}
{{--							<a href="{{ url('/referrals/prospects/new') }}" class="dropdown-item" key="t-default">New</a>--}}
{{--							<a href="{{ url('/referrals/prospects/list') }}" class="dropdown-item" key="t-default">List All </a>--}}
{{--							<a href="{{ url('/referrals/prospects/mylist') }}" class="dropdown-item" key="t-default">My List </a>--}}
{{--						</div>--}}
{{--					</li>--}}
{{--					<li class="nav-item dropdown">--}}
{{--						<a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboard" role="button"--}}
{{--						> <i class="bx bx-money me-2"></i><span key="t-dashboards">Collections</span>--}}
{{--							<div class="arrow-down"></div>--}}
{{--						</a>--}}
{{--						<div class="dropdown-menu" aria-labelledby="topnav-dashboard">--}}
{{--							<a href="{{ url('/dashboard/list/collection') }}" class="dropdown-item" key="t-default">List</a>--}}
{{--							--}}{{--                            <a href="{{ url('/dashboard/list/takeactions') }}" class="dropdown-item" key="t-default">Take Actions</a>--}}
{{--							<a href="{{ url('/dashboard/list/followup') }}" class="dropdown-item" key="t-default">Follow Up</a>--}}
{{--						</div>--}}
{{--					</li>--}}
{{--					<li class="nav-item dropdown">--}}
{{--						<a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboard" role="button"--}}
{{--						> <i class="bx bxs-file-pdf me-2"></i><span key="t-dashboards">Authorizations</span>--}}
{{--							<div class="arrow-down"></div>--}}
{{--						</a>--}}
{{--						<div class="dropdown-menu" aria-labelledby="topnav-dashboard">--}}
{{--							<a href="{{ url('/referrals/authorizations') }}" class="dropdown-item" key="t-default">List</a>--}}
{{--							--}}{{--                            <a href="{{ url('/referrals/authorizations/new') }}" class="dropdown-item" key="t-default">New</a>--}}
{{--						</div>--}}
{{--					</li>--}}
{{--					<li class="nav-item dropdown">--}}
{{--						<a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboard" role="button"--}}
{{--						> <i class="bx bx-list-ol me-2"></i><span key="t-dashboards">Reports</span>--}}
{{--							<div class="arrow-down"></div>--}}
{{--						</a>--}}
{{--						<div class="dropdown-menu" aria-labelledby="topnav-dashboard">--}}
{{--							<a href="{{ url('/reports/') }}" class="dropdown-item" key="t-default">Info</a>--}}
{{--							--}}{{--                            <a href="{{ url('/report/info-map') }}" class="dropdown-item" key="t-default">Info & Heat Map</a>--}}
{{--						</div>--}}
{{--					</li>--}}
{{--					--}}
{{--					--}}
{{--					<li class="nav-item dropdown">--}}
{{--						<a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboard" role="button"--}}
{{--						> <i class="bx bx-home-circle me-2"></i><span key="t-dashboards">Employees</span>--}}
{{--							<div class="arrow-down"></div>--}}
{{--						</a>--}}
{{--						<div class="dropdown-menu" aria-labelledby="topnav-dashboard">--}}
{{--							<a href="{{ url('/employees') }}" class="dropdown-item" key="t-default">List</a>--}}
{{--						</div>--}}
{{--					</li>--}}
{{--					--}}{{--                    <li class="nav-item dropdown">--}}
{{--					--}}{{--                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboard" role="button"--}}
{{--					--}}{{--                        >--}}
{{--					--}}{{--                            <i class="bx bx-home-circle me-2"></i><span key="t-dashboards">General</span> <div class="arrow-down"></div>--}}
{{--					--}}{{--                        </a>--}}
{{--					--}}{{--                        <div class="dropdown-menu" aria-labelledby="topnav-dashboard">--}}
{{--					--}}{{--                            <a href="{{ url('/general') }}" class="dropdown-item" key="t-default">List</a>--}}
{{--					--}}{{--                        </div>--}}
{{--					--}}{{--                    </li>--}}
{{--					--}}{{--					<li class="nav-item dropdown">--}}
{{--					--}}{{--						<a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-uielement" role="button"--}}
{{--					--}}{{--						>--}}
{{--					--}}{{--							<i class="bx bx-tone me-2"></i>--}}
{{--					--}}{{--							<span key="t-ui-elements"> UI Elements</span>--}}
{{--					--}}{{--							<div class="arrow-down"></div>--}}
{{--					--}}{{--						</a>--}}
{{--					--}}
{{--					--}}{{--						<div class="dropdown-menu mega-dropdown-menu px-2 dropdown-mega-menu-xl"--}}
{{--					--}}{{--							aria-labelledby="topnav-uielement">--}}
{{--					--}}{{--							<div class="row">--}}
{{--					--}}{{--								<div class="col-lg-4">--}}
{{--					--}}{{--									<div>--}}
{{--					--}}{{--										<a href="ui-alerts.html" class="dropdown-item" key="t-alerts">Alerts</a>--}}
{{--					--}}{{--										<a href="ui-buttons.html" class="dropdown-item" key="t-buttons">Buttons</a>--}}
{{--					--}}{{--										<a href="ui-cards.html" class="dropdown-item" key="t-cards">Cards</a>--}}
{{--					--}}{{--										<a href="ui-carousel.html" class="dropdown-item" key="t-carousel">Carousel</a>--}}
{{--					--}}{{--										<a href="ui-dropdowns.html" class="dropdown-item" key="t-dropdowns">Dropdowns</a>--}}
{{--					--}}{{--										<a href="ui-grid.html" class="dropdown-item" key="t-grid">Grid</a>--}}
{{--					--}}{{--										<a href="ui-images.html" class="dropdown-item" key="t-images">Images</a>--}}
{{--					--}}{{--										<a href="ui-lightbox.html" class="dropdown-item" key="t-lightbox">Lightbox</a>--}}
{{--					--}}{{--									</div>--}}
{{--					--}}{{--								</div>--}}
{{--					--}}{{--								<div class="col-lg-4">--}}
{{--					--}}{{--									<div>--}}
{{--					--}}{{--										<a href="ui-modals.html" class="dropdown-item" key="t-modals">Modals</a>--}}
{{--					--}}{{--										<a href="ui-offcanvas.html" class="dropdown-item" key="t-offcanvas">Offcanvas</a>--}}
{{--					--}}{{--										<a href="ui-rangeslider.html" class="dropdown-item" key="t-range-slider">Range Slider</a>--}}
{{--					--}}{{--										<a href="ui-session-timeout.html" class="dropdown-item" key="t-session-timeout">Session Timeout</a>--}}
{{--					--}}{{--										<a href="ui-progressbars.html" class="dropdown-item" key="t-progress-bars">Progress Bars</a>--}}
{{--					--}}{{--										<a href="ui-placeholders.html" class="dropdown-item" key="t-placeholders">Placeholders</a>--}}
{{--					--}}{{--										<a href="ui-sweet-alert.html" class="dropdown-item" key="t-sweet-alert">Sweet-Alert</a>--}}
{{--					--}}{{--										<a href="ui-tabs-accordions.html" class="dropdown-item" key="t-tabs-accordions">Tabs & Accordions</a>--}}
{{--					--}}{{--									</div>--}}
{{--					--}}{{--								</div>--}}
{{--					--}}{{--								<div class="col-lg-4">--}}
{{--					--}}{{--									<div>--}}
{{--					--}}{{--										<a href="ui-typography.html" class="dropdown-item" key="t-typography">Typography</a>--}}
{{--					--}}{{--										<a href="ui-toasts.html" class="dropdown-item" key="t-toasts">Toasts</a>--}}
{{--					--}}{{--										<a href="ui-video.html" class="dropdown-item" key="t-video">Video</a>--}}
{{--					--}}{{--										<a href="ui-general.html" class="dropdown-item" key="t-general">General</a>--}}
{{--					--}}{{--										<a href="ui-colors.html" class="dropdown-item" key="t-colors">Colors</a>--}}
{{--					--}}{{--										<a href="ui-rating.html" class="dropdown-item" key="t-rating">Rating</a>--}}
{{--					--}}{{--										<a href="ui-notifications.html" class="dropdown-item" key="t-notifications">Notifications</a>--}}
{{--					--}}{{--									</div>--}}
{{--					--}}{{--								</div>--}}
{{--					--}}{{--							</div>--}}
{{--					--}}
{{--					--}}{{--						</div>--}}
{{--					--}}{{--					</li>--}}
{{--					--}}
{{--					--}}{{--					<li class="nav-item dropdown">--}}
{{--					--}}{{--						<a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button"--}}
{{--					--}}{{--						>--}}
{{--					--}}{{--							<i class="bx bx-customize me-2"></i><span key="t-apps">Apps</span> <div class="arrow-down"></div>--}}
{{--					--}}{{--						</a>--}}
{{--					--}}{{--						<div class="dropdown-menu" aria-labelledby="topnav-pages">--}}
{{--					--}}
{{--					--}}{{--							<div class="dropdown">--}}
{{--					--}}{{--								<a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-email"--}}
{{--					--}}{{--									role="button">--}}
{{--					--}}{{--									<span key="t-calendar">Calendar</span> <div class="arrow-down"></div>--}}
{{--					--}}{{--								</a>--}}
{{--					--}}{{--								<div class="dropdown-menu" aria-labelledby="topnav-email">--}}
{{--					--}}{{--									<a href="calendar.html" class="dropdown-item" key="t-tui-calendar">TUI Calendar</a>--}}
{{--					--}}{{--									<a href="calendar-full.html" class="dropdown-item" key="t-full-calender">Full Calendar</a>--}}
{{--					--}}{{--								</div>--}}
{{--					--}}{{--							</div>--}}
{{--					--}}
{{--					--}}{{--							<a href="chat.html" class="dropdown-item" key="t-chat">Chat</a>--}}
{{--					--}}{{--							<a href="apps-filemanager.html" class="dropdown-item" key="t-file-manager">File Manager</a>--}}
{{--					--}}{{--							<div class="dropdown">--}}
{{--					--}}{{--								<a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-email"--}}
{{--					--}}{{--									role="button">--}}
{{--					--}}{{--									<span key="t-email">Email</span> <div class="arrow-down"></div>--}}
{{--					--}}{{--								</a>--}}
{{--					--}}{{--								<div class="dropdown-menu" aria-labelledby="topnav-email">--}}
{{--					--}}{{--									<a href="email-inbox.html" class="dropdown-item" key="t-inbox">Inbox</a>--}}
{{--					--}}{{--									<a href="email-read.html" class="dropdown-item" key="t-read-email">Read Email</a>--}}
{{--					--}}
{{--					--}}{{--									<div class="dropdown">--}}
{{--					--}}{{--										<a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-blog"--}}
{{--					--}}{{--											role="button">--}}
{{--					--}}{{--											<span key="t-email-templates">Templates</span> <div class="arrow-down"></div>--}}
{{--					--}}{{--										</a>--}}
{{--					--}}{{--										<div class="dropdown-menu" aria-labelledby="topnav-blog">--}}
{{--					--}}{{--											<a href="email-template-basic.html" class="dropdown-item" key="t-basic-action">Basic Action</a>--}}
{{--					--}}{{--											<a href="email-template-alert.html" class="dropdown-item" key="t-alert-email">Alert Email</a>--}}
{{--					--}}{{--											<a href="email-template-billing.html" class="dropdown-item" key="t-bill-email">Billing Email</a>--}}
{{--					--}}{{--										</div>--}}
{{--					--}}{{--									</div>--}}
{{--					--}}{{--								</div>--}}
{{--					--}}{{--							</div>--}}
{{--					--}}
{{--					--}}{{--							<div class="dropdown">--}}
{{--					--}}{{--								<a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-ecommerce"--}}
{{--					--}}{{--									role="button">--}}
{{--					--}}{{--									<span key="t-ecommerce">Ecommerce</span> <div class="arrow-down"></div>--}}
{{--					--}}{{--								</a>--}}
{{--					--}}{{--								<div class="dropdown-menu" aria-labelledby="topnav-ecommerce">--}}
{{--					--}}{{--									<a href="ecommerce-products.html" class="dropdown-item" key="t-products">Products</a>--}}
{{--					--}}{{--									<a href="ecommerce-product-detail.html" class="dropdown-item" key="t-product-detail">Product Detail</a>--}}
{{--					--}}{{--									<a href="ecommerce-orders.html" class="dropdown-item" key="t-orders">Orders</a>--}}
{{--					--}}{{--									<a href="ecommerce-customers.html" class="dropdown-item" key="t-customers">Customers</a>--}}
{{--					--}}{{--									<a href="ecommerce-cart.html" class="dropdown-item" key="t-cart">Cart</a>--}}
{{--					--}}{{--									<a href="ecommerce-checkout.html" class="dropdown-item" key="t-checkout">Checkout</a>--}}
{{--					--}}{{--									<a href="ecommerce-shops.html" class="dropdown-item" key="t-shops">Shops</a>--}}
{{--					--}}{{--									<a href="ecommerce-add-product.html" class="dropdown-item" key="t-add-product">Add Product</a>--}}
{{--					--}}{{--								</div>--}}
{{--					--}}{{--							</div>--}}
{{--					--}}
{{--					--}}{{--							<div class="dropdown">--}}
{{--					--}}{{--								<a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-crypto"--}}
{{--					--}}{{--									role="button">--}}
{{--					--}}{{--									<span key="t-crypto">Crypto</span> <div class="arrow-down"></div>--}}
{{--					--}}{{--								</a>--}}
{{--					--}}{{--								<div class="dropdown-menu" aria-labelledby="topnav-crypto">--}}
{{--					--}}{{--									<a href="crypto-wallet.html" class="dropdown-item" key="t-wallet">Wallet</a>--}}
{{--					--}}{{--									<a href="crypto-buy-sell.html" class="dropdown-item" key="t-buy">Buy/Sell</a>--}}
{{--					--}}{{--									<a href="crypto-exchange.html" class="dropdown-item" key="t-exchange">Exchange</a>--}}
{{--					--}}{{--									<a href="crypto-lending.html" class="dropdown-item" key="t-lending">Lending</a>--}}
{{--					--}}{{--									<a href="crypto-orders.html" class="dropdown-item" key="t-orders">Orders</a>--}}
{{--					--}}{{--									<a href="crypto-kyc-application.html" class="dropdown-item" key="t-kyc">KYC Application</a>--}}
{{--					--}}{{--									<a href="crypto-ico-landing.html" class="dropdown-item" key="t-ico">ICO Landing</a>--}}
{{--					--}}{{--								</div>--}}
{{--					--}}{{--							</div>--}}
{{--					--}}
{{--					--}}{{--							<div class="dropdown">--}}
{{--					--}}{{--								<a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-project"--}}
{{--					--}}{{--									role="button">--}}
{{--					--}}{{--									<span key="t-projects">Projects</span> <div class="arrow-down"></div>--}}
{{--					--}}{{--								</a>--}}
{{--					--}}{{--								<div class="dropdown-menu" aria-labelledby="topnav-project">--}}
{{--					--}}{{--									<a href="projects-grid.html" class="dropdown-item" key="t-p-grid">Projects Grid</a>--}}
{{--					--}}{{--									<a href="projects-list.html" class="dropdown-item" key="t-p-list">Projects List</a>--}}
{{--					--}}{{--									<a href="projects-overview.html" class="dropdown-item" key="t-p-overview">Project Overview</a>--}}
{{--					--}}{{--									<a href="projects-create.html" class="dropdown-item" key="t-create-new">Create New</a>--}}
{{--					--}}{{--								</div>--}}
{{--					--}}{{--							</div>--}}
{{--					--}}{{--							<div class="dropdown">--}}
{{--					--}}{{--								<a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-task"--}}
{{--					--}}{{--									role="button">--}}
{{--					--}}{{--									<span key="t-tasks">Tasks</span> <div class="arrow-down"></div>--}}
{{--					--}}{{--								</a>--}}
{{--					--}}{{--								<div class="dropdown-menu" aria-labelledby="topnav-task">--}}
{{--					--}}{{--									<a href="tasks-list.html" class="dropdown-item" key="t-task-list">Task List</a>--}}
{{--					--}}{{--									<a href="tasks-kanban.html" class="dropdown-item" key="t-kanban-board">Kanban Board</a>--}}
{{--					--}}{{--									<a href="tasks-create.html" class="dropdown-item" key="t-create-task">Create Task</a>--}}
{{--					--}}{{--								</div>--}}
{{--					--}}{{--							</div>--}}
{{--					--}}{{--							<div class="dropdown">--}}
{{--					--}}{{--								<a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-contact"--}}
{{--					--}}{{--									role="button">--}}
{{--					--}}{{--									<span key="t-contacts">Contacts</span> <div class="arrow-down"></div>--}}
{{--					--}}{{--								</a>--}}
{{--					--}}{{--								<div class="dropdown-menu" aria-labelledby="topnav-contact">--}}
{{--					--}}{{--									<a href="contacts-grid.html" class="dropdown-item" key="t-user-grid">User Grid</a>--}}
{{--					--}}{{--									<a href="contacts-list.html" class="dropdown-item" key="t-user-list">User List</a>--}}
{{--					--}}{{--									<a href="contacts-profile.html" class="dropdown-item" key="t-profile">Profile</a>--}}
{{--					--}}{{--								</div>--}}
{{--					--}}{{--							</div>--}}
{{--					--}}
{{--					--}}{{--							<div class="dropdown">--}}
{{--					--}}{{--								<a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-blog"--}}
{{--					--}}{{--									role="button">--}}
{{--					--}}{{--									<span key="t-blog">Blog</span> <div class="arrow-down"></div>--}}
{{--					--}}{{--								</a>--}}
{{--					--}}{{--								<div class="dropdown-menu" aria-labelledby="topnav-blog">--}}
{{--					--}}{{--									<a href="blog-list.html" class="dropdown-item" key="t-blog-list">Blog List</a>--}}
{{--					--}}{{--									<a href="blog-grid.html" class="dropdown-item" key="t-blog-grid">Blog Grid</a>--}}
{{--					--}}{{--									<a href="blog-details.html" class="dropdown-item" key="t-blog-details">Blog Details</a>--}}
{{--					--}}{{--								</div>--}}
{{--					--}}{{--							</div>--}}
{{--					--}}{{--						</div>--}}
{{--					--}}{{--					</li>--}}
{{--					--}}
{{--					--}}{{--					<li class="nav-item dropdown">--}}
{{--					--}}{{--						<a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-components" role="button"--}}
{{--					--}}{{--						>--}}
{{--					--}}{{--							<i class="bx bx-collection me-2"></i><span key="t-components">Components</span> <div class="arrow-down"></div>--}}
{{--					--}}{{--						</a>--}}
{{--					--}}{{--						<div class="dropdown-menu" aria-labelledby="topnav-components">--}}
{{--					--}}{{--							<div class="dropdown">--}}
{{--					--}}{{--								<a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"--}}
{{--					--}}{{--									role="button">--}}
{{--					--}}{{--									<span key="t-forms">Forms</span> <div class="arrow-down"></div>--}}
{{--					--}}{{--								</a>--}}
{{--					--}}{{--								<div class="dropdown-menu" aria-labelledby="topnav-form">--}}
{{--					--}}{{--									<a href="form-elements.html" class="dropdown-item" key="t-form-elements">Form Elements</a>--}}
{{--					--}}{{--									<a href="form-layouts.html" class="dropdown-item" key="t-form-layouts">Form Layouts</a>--}}
{{--					--}}{{--									<a href="form-validation.html" class="dropdown-item" key="t-form-validation">Form Validation</a>--}}
{{--					--}}{{--									<a href="form-advanced.html" class="dropdown-item" key="t-form-advanced">Form Advanced</a>--}}
{{--					--}}{{--									<a href="form-editors.html" class="dropdown-item" key="t-form-editors">Form Editors</a>--}}
{{--					--}}{{--									<a href="form-uploads.html" class="dropdown-item" key="t-form-upload">Form File Upload</a>--}}
{{--					--}}{{--									<a href="form-xeditable.html" class="dropdown-item" key="t-form-xeditable">Form Xeditable</a>--}}
{{--					--}}{{--									<a href="form-repeater.html" class="dropdown-item" key="t-form-repeater">Form Repeater</a>--}}
{{--					--}}{{--									<a href="form-wizard.html" class="dropdown-item" key="t-form-wizard">Form Wizard</a>--}}
{{--					--}}{{--									<a href="form-mask.html" class="dropdown-item" key="t-form-mask">Form Mask</a>--}}
{{--					--}}{{--								</div>--}}
{{--					--}}{{--							</div>--}}
{{--					--}}{{--							<div class="dropdown">--}}
{{--					--}}{{--								<a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-table"--}}
{{--					--}}{{--									role="button">--}}
{{--					--}}{{--									<span key="t-tables">Tables</span> <div class="arrow-down"></div>--}}
{{--					--}}{{--								</a>--}}
{{--					--}}{{--								<div class="dropdown-menu" aria-labelledby="topnav-table">--}}
{{--					--}}{{--									<a href="tables-basic.html" class="dropdown-item" key="t-basic-tables">Basic Tables</a>--}}
{{--					--}}{{--									<a href="tables-datatable.html" class="dropdown-item" key="t-data-tables">Data Tables</a>--}}
{{--					--}}{{--									<a href="tables-responsive.html" class="dropdown-item" key="t-responsive-table">Responsive Table</a>--}}
{{--					--}}{{--									<a href="tables-editable.html" class="dropdown-item" key="t-editable-table">Editable Table</a>--}}
{{--					--}}{{--								</div>--}}
{{--					--}}{{--							</div>--}}
{{--					--}}{{--							<div class="dropdown">--}}
{{--					--}}{{--								<a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-charts"--}}
{{--					--}}{{--									role="button">--}}
{{--					--}}{{--									<span key="t-charts">Charts</span> <div class="arrow-down"></div>--}}
{{--					--}}{{--								</a>--}}
{{--					--}}{{--								<div class="dropdown-menu" aria-labelledby="topnav-charts">--}}
{{--					--}}{{--									<a href="charts-apex.html" class="dropdown-item" key="t-apex-charts">Apex charts</a>--}}
{{--					--}}{{--									<a href="charts-echart.html" class="dropdown-item" key="t-e-charts">E charts</a>--}}
{{--					--}}{{--									<a href="charts-chartjs.html" class="dropdown-item" key="t-chartjs-charts">Chartjs Charts</a>--}}
{{--					--}}{{--									<a href="charts-flot.html" class="dropdown-item" key="t-flot-charts">Flot Charts</a>--}}
{{--					--}}{{--									<a href="charts-tui.html" class="dropdown-item" key="t-ui-charts">Toast UI Charts</a>--}}
{{--					--}}{{--									<a href="charts-knob.html" class="dropdown-item" key="t-knob-charts">Jquery Knob Charts</a>--}}
{{--					--}}{{--									<a href="charts-sparkline.html" class="dropdown-item" key="t-sparkline-charts">Sparkline Charts</a>--}}
{{--					--}}{{--								</div>--}}
{{--					--}}{{--							</div>--}}
{{--					--}}{{--							<div class="dropdown">--}}
{{--					--}}{{--								<a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-icons"--}}
{{--					--}}{{--									role="button">--}}
{{--					--}}{{--									<span key="t-icons">Icons</span> <div class="arrow-down"></div>--}}
{{--					--}}{{--								</a>--}}
{{--					--}}{{--								<div class="dropdown-menu" aria-labelledby="topnav-icons">--}}
{{--					--}}{{--									<a href="icons-boxicons.html" class="dropdown-item" key="t-boxicons">Boxicons</a>--}}
{{--					--}}{{--									<a href="icons-materialdesign.html" class="dropdown-item" key="t-material-design">Material Design</a>--}}
{{--					--}}{{--									<a href="icons-dripicons.html" class="dropdown-item" key="t-dripicons">Dripicons</a>--}}
{{--					--}}{{--									<a href="icons-fontawesome.html" class="dropdown-item" key="t-font-awesome">Font awesome</a>--}}
{{--					--}}{{--								</div>--}}
{{--					--}}{{--							</div>--}}
{{--					--}}{{--							<div class="dropdown">--}}
{{--					--}}{{--								<a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-map"--}}
{{--					--}}{{--									role="button">--}}
{{--					--}}{{--									<span key="t-maps">Maps</span> <div class="arrow-down"></div>--}}
{{--					--}}{{--								</a>--}}
{{--					--}}{{--								<div class="dropdown-menu" aria-labelledby="topnav-map">--}}
{{--					--}}{{--									<a href="maps-google.html" class="dropdown-item" key="t-g-maps">Google Maps</a>--}}
{{--					--}}{{--									<a href="maps-vector.html" class="dropdown-item" key="t-v-maps">Vector Maps</a>--}}
{{--					--}}{{--									<a href="maps-leaflet.html" class="dropdown-item" key="t-l-maps">Leaflet Maps</a>--}}
{{--					--}}{{--								</div>--}}
{{--					--}}{{--							</div>--}}
{{--					--}}{{--						</div>--}}
{{--					--}}{{--					</li>--}}
{{--					--}}
{{--					--}}{{--					<li class="nav-item dropdown">--}}
{{--					--}}{{--						<a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-more" role="button"--}}
{{--					--}}{{--						>--}}
{{--					--}}{{--							<i class="bx bx-file me-2"></i><span key="t-extra-pages">Extra pages</span> <div class="arrow-down"></div>--}}
{{--					--}}{{--						</a>--}}
{{--					--}}{{--						<div class="dropdown-menu" aria-labelledby="topnav-more">--}}
{{--					--}}{{--							<div class="dropdown">--}}
{{--					--}}{{--								<a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-invoice"--}}
{{--					--}}{{--									role="button">--}}
{{--					--}}{{--									<span key="t-invoices">Invoices</span> <div class="arrow-down"></div>--}}
{{--					--}}{{--								</a>--}}
{{--					--}}{{--								<div class="dropdown-menu" aria-labelledby="topnav-invoice">--}}
{{--					--}}{{--									<a href="invoices-list.html" class="dropdown-item" key="t-invoice-list">Invoice List</a>--}}
{{--					--}}{{--									<a href="invoices-detail.html" class="dropdown-item" key="t-invoice-detail">Invoice Detail</a>--}}
{{--					--}}{{--								</div>--}}
{{--					--}}{{--							</div>--}}
{{--					--}}{{--							<div class="dropdown">--}}
{{--					--}}{{--								<a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-auth"--}}
{{--					--}}{{--									role="button">--}}
{{--					--}}{{--									<span key="t-authentication">Authentication</span> <div class="arrow-down"></div>--}}
{{--					--}}{{--								</a>--}}
{{--					--}}{{--								<div class="dropdown-menu" aria-labelledby="topnav-auth">--}}
{{--					--}}{{--									<a href="auth-login.html" class="dropdown-item" key="t-login">Login</a>--}}
{{--					--}}{{--									<a href="auth-login-2.html" class="dropdown-item" key="t-login-2">Login 2</a>--}}
{{--					--}}{{--									<a href="auth-register.html" class="dropdown-item" key="t-register">Register</a>--}}
{{--					--}}{{--									<a href="auth-register-2.html" class="dropdown-item" key="t-register-2">Register 2</a>--}}
{{--					--}}{{--									<a href="auth-recoverpw.html" class="dropdown-item" key="t-recover-password">Recover Password</a>--}}
{{--					--}}{{--									<a href="auth-recoverpw-2.html" class="dropdown-item" key="t-recover-password-2">Recover Password 2</a>--}}
{{--					--}}{{--									<a href="auth-lock-screen.html" class="dropdown-item" key="t-lock-screen">Lock Screen</a>--}}
{{--					--}}{{--									<a href="auth-lock-screen-2.html" class="dropdown-item" key="t-lock-screen-2">Lock Screen 2</a>--}}
{{--					--}}{{--									<a href="auth-confirm-mail.html" class="dropdown-item" key="t-confirm-mail">Confirm Mail</a>--}}
{{--					--}}{{--									<a href="auth-confirm-mail-2.html" class="dropdown-item" key="t-confirm-mail-2">Confirm Mail 2</a>--}}
{{--					--}}{{--									<a href="auth-email-verification.html" class="dropdown-item" key="t-email-verification">Email verification</a>--}}
{{--					--}}{{--									<a href="auth-email-verification-2.html" class="dropdown-item" key="t-email-verification-2">Email verification 2</a>--}}
{{--					--}}{{--									<a href="auth-two-step-verification.html" class="dropdown-item" key="t-two-step-verification">Two step verification</a>--}}
{{--					--}}{{--									<a href="auth-two-step-verification-2.html" class="dropdown-item" key="t-two-step-verification-2">Two step verification 2</a>--}}
{{--					--}}{{--								</div>--}}
{{--					--}}{{--							</div>--}}
{{--					--}}{{--							<div class="dropdown">--}}
{{--					--}}{{--								<a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-utility"--}}
{{--					--}}{{--									role="button">--}}
{{--					--}}{{--									<span key="t-utility">Utility</span> <div class="arrow-down"></div>--}}
{{--					--}}{{--								</a>--}}
{{--					--}}{{--								<div class="dropdown-menu" aria-labelledby="topnav-utility">--}}
{{--					--}}{{--									<a href="pages-starter.html" class="dropdown-item" key="t-starter-page">Starter Page</a>--}}
{{--					--}}{{--									<a href="pages-maintenance.html" class="dropdown-item" key="t-maintenance">Maintenance</a>--}}
{{--					--}}{{--									<a href="pages-comingsoon.html" class="dropdown-item" key="t-coming-soon">Coming Soon</a>--}}
{{--					--}}{{--									<a href="pages-timeline.html" class="dropdown-item" key="t-timeline">Timeline</a>--}}
{{--					--}}{{--									<a href="pages-faqs.html" class="dropdown-item" key="t-faqs">FAQs</a>--}}
{{--					--}}{{--									<a href="pages-pricing.html" class="dropdown-item" key="t-pricing">Pricing</a>--}}
{{--					--}}{{--									<a href="pages-404.html" class="dropdown-item" key="t-error-404">Error 404</a>--}}
{{--					--}}{{--									<a href="pages-500.html" class="dropdown-item" key="t-error-500">Error 500</a>--}}
{{--					--}}{{--								</div>--}}
{{--					--}}{{--							</div>--}}
{{--					--}}{{--						</div>--}}
{{--					--}}{{--					</li>--}}
{{--					--}}
{{--					--}}{{--					<li class="nav-item dropdown">--}}
{{--					--}}{{--						<a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"--}}
{{--					--}}{{--						>--}}
{{--					--}}{{--							<i class="bx bx-layout me-2"></i><span key="t-layouts">Layouts</span> <div class="arrow-down"></div>--}}
{{--					--}}{{--						</a>--}}
{{--					--}}{{--						<div class="dropdown-menu" aria-labelledby="topnav-layout">--}}
{{--					--}}{{--							<div class="dropdown">--}}
{{--					--}}{{--								<a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-verti"--}}
{{--					--}}{{--									role="button">--}}
{{--					--}}{{--									<span key="t-vertical">Vertical</span> <div class="arrow-down"></div>--}}
{{--					--}}{{--								</a>--}}
{{--					--}}{{--								<div class="dropdown-menu" aria-labelledby="topnav-layout-verti">--}}
{{--					--}}{{--									<a href="layouts-light-sidebar.html" class="dropdown-item" key="t-light-sidebar">Light Sidebar</a>--}}
{{--					--}}{{--									<a href="layouts-compact-sidebar.html" class="dropdown-item" key="t-compact-sidebar">Compact Sidebar</a>--}}
{{--					--}}{{--									<a href="layouts-icon-sidebar.html" class="dropdown-item" key="t-icon-sidebar">Icon Sidebar</a>--}}
{{--					--}}{{--									<a href="layouts-boxed.html" class="dropdown-item" key="t-boxed-width">Boxed Width</a>--}}
{{--					--}}{{--									<a href="layouts-preloader.html" class="dropdown-item" key="t-preloader">Preloader</a>--}}
{{--					--}}{{--									<a href="layouts-colored-sidebar.html" class="dropdown-item" key="t-colored-sidebar">Colored Sidebar</a>--}}
{{--					--}}{{--									<a href="layouts-scrollable.html" class="dropdown-item" key="t-scrollable">Scrollable</a>--}}
{{--					--}}{{--								</div>--}}
{{--					--}}{{--							</div>--}}
{{--					--}}
{{--					--}}{{--							<div class="dropdown">--}}
{{--					--}}{{--								<a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-hori"--}}
{{--					--}}{{--									role="button">--}}
{{--					--}}{{--									<span key="t-horizontal">Horizontal</span> <div class="arrow-down"></div>--}}
{{--					--}}{{--								</a>--}}
{{--					--}}{{--								<div class="dropdown-menu" aria-labelledby="topnav-layout-hori">--}}
{{--					--}}{{--									<a href="layouts-horizontal.html" class="dropdown-item" key="t-horizontal">Horizontal</a>--}}
{{--					--}}{{--									<a href="layouts-hori-topbar-light.html" class="dropdown-item" key="t-topbar-light">Topbar light</a>--}}
{{--					--}}{{--									<a href="layouts-hori-boxed-width.html" class="dropdown-item" key="t-boxed-width">Boxed width</a>--}}
{{--					--}}{{--									<a href="layouts-hori-preloader.html" class="dropdown-item" key="t-preloader">Preloader</a>--}}
{{--					--}}{{--									<a href="layouts-hori-colored-header.html" class="dropdown-item" key="t-colored-topbar">Colored Header</a>--}}
{{--					--}}{{--									<a href="layouts-hori-scrollable.html" class="dropdown-item" key="t-scrollable">Scrollable</a>--}}
{{--					--}}{{--								</div>--}}
{{--					--}}{{--							</div>--}}
{{--					--}}{{--						</div>--}}
{{--					--}}{{--					</li>--}}
{{--				--}}
{{--				</ul>--}}
			
			</div>
		</nav>
	</div>
</div>
<!-- Topbar End -->
