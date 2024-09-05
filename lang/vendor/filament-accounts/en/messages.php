<?php

return [
    "save" => "Save",
    "saved_successfully" => "Saved Successfully",
    "group" => "Accounts",
    "accounts" => [
        "label" => "Accounts",
        "single" => "Account",
        "coulmns" => [
            "id" => "ID",
            "avatar" => "Avatar",
            "teams" => "Teams",
            "name" => "Name",
            "email" => "Email",
            "phone" => "Phone",
            "type" => "Type",
            "address" => "Address",
            "password" => "Password",
            "password_confirmation" => "Password Confirmation",
            "loginBy" => "Login By",
            "is_active" => "Is Active?",
            "is_login" => "Can Login?",
            "created_at" => "Created At",
            "updated_at" => "Updated At",
        ],
        "filters" => [
            "type" => "Type",
            "teams" => "Teams",
            "is_active" => "Is Active?",
            "is_login" => "Can Login?",
        ],
        "actions" => [
            "teams" => "Manage Teams",
            "impersonate" => "Login As",
            "password" => "Change Password",
            "notifications" => "Send Notifications",
            "edit" => "Edit",
            "delete" => "Delete",
            "force_delete" => "Force Delete",
            "restore" => "Restore",
        ],
        "notifications" => [
            "use_notification_template" => "Use Notification Template",
            "template_id" => "Template",
            "image" => "Image",
            "title" => "Title",
            "body" => "Body",
            "action" => "Action",
            "url" => "URL",
            "icon" => "Icon",
            "type" => "Type",
            "providers" => "Send By"
        ],
        "export" => [
            "title" => "Export",
            "columns" => "Columns"
        ],
        "import" => [
            "title" => "Import",
            "excel" => "Excel",
            "hint" => "You can upload the same style of exported file",
            "success" => 'Success',
            "body" => 'Accounts imported successfully',
            "error" => "Error",
            "error-body" => "Error while importing accounts",
        ]
    ],
    "meta" => [
        "label" => "Metas",
        "single" => "Meta",
        "create" => "Create Meta",
        "columns" => [
            "account" => "Account",
            "key" => "Key",
            "value" => "Value"
        ],
    ],
    "locations" => [
        "label" => "Locations",
        "single" => "Location",
        "create" => "Create Location",
    ],
    "requests" => [
        "label" => "Account Requests",
        "single" => "Account Request",
        "columns" => [
            "account" => "Account",
            "user" => "User",
            "type" => "Type",
            "status" => "Status",
            "is_approved" => "Is Approved?",
            "is_approved_at" => "Is Approved At"
        ],
    ],
    "contacts" => [
        "label" => "Contacts",
        "single" => "Contact",
        "columns" => [
            "type" => "Type",
            "status" => "Status",
            "name" => "Name",
            "email" => "Email",
            "phone" => "Phone",
            "subject" => "Subject",
            "message" => "Message",
            "active" => "Active"
        ],
    ],
    "profile" => [
        "title" => "Edit Profile",
        "edit" => [
            "title" => "Edit Information",
            "description" => "Update your account's profile information and email address.",
            "name" => "Name",
            "email" => "Email",
        ],
        "password" => [
            "title" => "Change Password",
            "description" => "Ensure your account is using a long, random password to stay secure.",
            "current_password" => "Current Password",
            "new_password" => "New Password",
            "confirm_password" => "Confirm Password",
        ],
        "browser" => [
            "sessions_last_active"  => "Last Active",
            "browser_section_title" => "Browser Sessions",
            "browser_section_description" => "Manage and log out your active sessions on other browsers and devices.",
            "browser_sessions_log_out" => "Log Out Other Browser Sessions",
            "browser_sessions_confirm_pass" => "Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices.",
            "password" => "Password",
            "confirm" => "Confirm",
            "nevermind" => "Nevermind",
            "browser_sessions_logout_notification" => "Your browser sessions have been logged out.",
            "browser_sessions_logout_failed_notification" => "Your password was incorrect.",
            "sessions_device" => "Device",
            "sessions_content"=> "Connected Devices",
            "incorrect_password" => "The password you entered was incorrect.",
        ],
        "delete" => [
            "delete_account" => "Delete Account",
            "delete_account_description" => "Permanently delete your account.",
            "incorrect_password" => "The password you entered was incorrect.",
            "are_you_sure" => "Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.",
            "yes_delete_it" => "Yes, delete it",
            "password" => "Password",
            "delete_account_card_description" => "Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.",
        ],
        "delete-team" => [
            "title" => "Delete Team",
            "description" => "Permanently delete your team.",
            "body" => "Once a team is deleted, all of its resources and data will be permanently deleted. Before deleting this team, please download any data or information regarding this team that you wish to retain.",
            "delete" => "Delete Team",
            "delete_account" => "Delete Team",
            "delete_account_description" => "Are you sure you want to delete your team? Once your team is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your team.",
            "yes_delete_it" => "Yes, delete it",
            "password" => "Password",
            "incorrect_password" => "The password you entered was incorrect.",
            "are_you_sure" => "Are you sure you want to delete your team? Once your team is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your team.",
        ],
        "token" => [
            "title" => "API Tokens",
            "description" => "API tokens allow third-party services to authenticate with our application on your behalf.",
            "name" => "Name",
            "created_at" => "Created At",
            "expires_at" => "Expires At",
            "abilities" => "Abilities",
            "action_label" => "Create Token",
            "create_notification" => "Token created successfully!",
            "modal_heading" => "Create Token",
            "empty_state_heading" => "No tokens",
            "empty_state_description" => "Create a new token to authenticate with the API.",
            "delete_token" => "Delete Token",
            "delete_token_description" => "Are you sure you would like to delete this token?",
            "delete_token_confirmation" => "Yes, delete it",
            "delete_token_notification" => "Token deleted successfully!",
            "modal_heading_2" => "Token Generated Successfully",
            "helper_text" => "You may edit the token below. Make sure to copy it now, as you won't be able to see it again.",
            "token" => "Token",
        ],
    ],
    "teams" => [
        "title" => "Team Settings",
        "actions" => [
            "cancel_invitation" => "Cancel Invitation",
            "resend_invitation" => "Resend Invitation",
        ],
        "edit" => [
            "title" => "Edit Team Name",
            "description" => "Update your team's profile information and email address.",
            "name" => "Name",
            "email" => "Email",
            "avatar" => "Avatar",
            "save" => "Save",
            "owner" => "Owner"
        ],
        "members" => [
            "title" => "Invite Team Members",
            "description" => "Add a new team member to your team, allowing them to collaborate with you.",
            "team-members"=> "Please provide the email address of the person you would like to add to this team.",
            "email" => "Email",
            "role" => "Role",
            "send_invitation" => "Send Invitation",
            "cancel" => "Cancel",
            "not_in" => "The email address is already a team member.",
            "required" => "The email field is required.",
            "unique" => "The email address is already a team member.",
            "role_required" => "The role field is required.",
            "notifications" => [
                "title" => "Team Member Invitation",
                "body" => "You have been invited to join the :team team.",
                "accept" => "Accept Invitation",
                "cancel" => "Cancel Invitation"
            ],
            "leave_team" => "Leave Team",
            "remove_member" => "Remove Member",
            "manage_role" => "Manage Role",
            "list" => [
                "title" => "Team Members",
                "description" => "All of the people that are part of this team.",
            ]
        ],
        "delete" => [
            "title" => "Delete Team",
            "description" => "Permanently delete your team.",
            "body" => "Once a team is deleted, all of its resources and data will be permanently deleted. Before deleting this team, please download any data or information regarding this team that you wish to retain.",
            "delete" => "Delete Team",
            "delete_account" => "Delete Team",
            "delete_account_description" => "Are you sure you want to delete your team? Once your team is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your team.",
            "yes_delete_it" => "Yes, delete it",
            "password" => "Password",
            "incorrect_password" => "The password you entered was incorrect.",
            "are_you_sure" => "Are you sure you want to delete your team? Once your team is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your team.",
        ],
    ],
    "team" => [
        "title" => "Teams",
        "single" => "Team",
        "columns" => [
            "avatar" => "Avatar",
            "name" => "Name",
            "owner" => "Owner",
            "personal_team" => "Personal Team",
        ],
    ],

    "roles" => [
        "admin" => [
            "name" => "Administrator",
            "description" => "Administrator users can perform any action."
        ],
        "user" =>[
            "name" =>  "User",
            "description" => "User users can read and update data."
        ],
    ],
    "login" => [
        "active" => "Please Verify Your Account First, than try to login again",
    ],


    "settings" => [
        "types" => [
            "title" => "Accounts Types"
        ]
    ],

    "address" => [
        "title" => "Edit Locations"
    ],

    "account-requests" => [
        "title" => "Requests",
        "status" => "Request Status",
        "types" => "Request Types",
        "button" => "Manage Types & Status"
    ],

    "contact-us" => [
        "status" => "Edit Contact Us Status",
        "status-button" => "Manage Status",
        "footer" => "Do you have any problems or questions? Please",
        "modal" => 'Please Fill This Form To Contact Us',
        "label" => "Contact Us",
        "form" => [
            "name" => "Name",
            "email" => "Email",
            "phone" => "Phone",
            "subject" => "Subject",
            "message" => "Message",
        ],
        "notification" => [
            "title" => "Contact Us",
            "body" => "Your message has been sent successfully",
        ]
    ]
];
