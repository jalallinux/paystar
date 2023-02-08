module.exports = {
    apps: [
        {
            namespace: "PAYSTAR-SCHEDULE",
            name: "scheduler-work",
            interpreter: "php",
            script: "artisan",
            exec_mode: "fork",
            instances: 1,
            autorestart: true,
            cron_restart: "* * * * *",
            max_memory_restart: "100M",
            args: [
                "schedule:work",
            ],
        },
        {
            namespace: "PAYSTAR-QUEUE",
            name: "default-on-database",
            interpreter: "php",
            script: "artisan",
            exec_mode: "fork",
            instances: 4,
            autorestart: true,
            cron_restart: "* 3 * * *",
            max_memory_restart: "200M",
            args: [
                "queue:work",
                "database",
                "--queue=default",
                "--tries=3",
            ],
        },
    ]
}
