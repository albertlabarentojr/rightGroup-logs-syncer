# rightmartGroup aggregated log syncer app


## Requirements
1. Make command https://formulae.brew.sh/formula/make
2. Docker Compose

## Let's run the app

1. Run a single command in one go to make it up and running
   > `make setup`

2. Navigate to https://localhost/dashboard
   - Initially, we don't have any logs yet

3. Let's sync our logs from an aggregated log file located at `shared_logs/logs.log`
   > `make sync_logs`
   ![Screenshot 2025-04-01 at 11.47.12 PM.png](readme_files/Screenshot%202025-04-01%20at%2011.47.12%E2%80%AFPM.png)

4. Once synced, logs will be stored in the database
    > ![Screenshot 2025-04-01 at 11.49.44 PM.png](readme_files/Screenshot%202025-04-01%20at%2011.49.44%E2%80%AFPM.png)

5. Synced logs are tracked using a Sync Log History. Since we have 996 logs from logs.log, our initial history will be recorded as shown in the attached file. This approach ensures that other services can continue writing to the log file while allowing us to sync it efficiently, minimizing performance risks as the file grows larger.
   > ![Screenshot 2025-04-01 at 11.51.47 PM.png](readme_files/Screenshot%202025-04-01%20at%2011.51.47%E2%80%AFPM.png)

6. Finally navigate to the dashboard page again https://localhost/dashboard, you should see that the table is properly populated from our synced logs
   > ![Screenshot 2025-04-01 at 11.56.46 PM.png](readme_files/Screenshot%202025-04-01%20at%2011.56.46%E2%80%AFPM.png)
