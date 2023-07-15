
# Glide Tech Test

Contains 2 tasks. Task 1, importing a CSV of OUI Data into a database table. Task 2 involves querying that table using an API.

## Task 1

For the CSV import I have created an artisan command.

#### Import CSV files placed in the public/csv folder

```
  php artisan csv:import {filename}
```

| Parameter | Type     | Example                |
| :-------- | :------- | :------------------------- |
| `filename` | `string` | File: `public/csv/oui.csv` |
|  |  | Command: `php artisan csv:import oui.csv` |


## Task 2

Querying database using API

### API Reference

No specific formatting required for querying a MAC address, as the API will strip out extra characters and convert to uppercase

#### GET Request

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `/api/mac_lookup/{query}` | `GET` | Queries database for a single MAC address as string. |

#### Example:
`api/mac_lookup/00-B0-D0-63-C2-26`\
\
Response:
```{
        "mac_address": "00-B0-D0-63-C2-26",
        "vendor": "Dell Inc."
    }
```        

#### POST Request
| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `/api/multi_mac_lookup/` | `POST` | Queries database for a multiple comma-separated MAC addresses as string. |

#### Example:
`api/multi_mac_lookup?mac_addresses=00-B0-D0-63-C2-26,2015821A0E60,92:B1:B8:42:D1:85`\
\
Response:
```
    {
        "mac_address": "00-B0-D0-63-C2-26",
        "vendor": "Dell Inc."
    },
    {
        "mac_address": "2015821A0E60",
        "vendor": "Apple, Inc."
    },
    {
        "mac_address": "92:B1:B8:42:D1:85",
        "vendor": "No matching result",
        "notes": "The second character of this MAC Address indicates this could possibly be randomised"
    }
```        
