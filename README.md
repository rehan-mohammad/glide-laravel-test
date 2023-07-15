
# Glide Tech Test

Contains 2 tasks. Task 1, importing a CSV of OUI Data into a database table. Task 2 involves querying that table using an API.

## Task 1

#### Import CSV files placed in the public/csv folder

To import, place your csv file in the public/csv folder, and input the following command specifying the filename.

```
  php artisan csv:import {filename}
```

#### CSV Formatting:
To correctly import, the CSV file should be formatted with the headers:
- Registry
- Assignment
- Organization Name
- Organization Address

### Command Reference

| Parameter | Type     | Example                |
| :-------- | :------- | :------------------------- |
| `filename` | `string` | File: `public/csv/oui.csv` |
|  |  | Command: `php artisan csv:import oui.csv` |


