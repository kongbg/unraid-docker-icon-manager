# Docker Icon Manager Plugin for Unraid

[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](LICENSE)

## Features

- Manage icons for Docker containers installed via code
- Upload custom icons for containers
- Automatic template generation for icon recognition
- Web interface for easy management
- Multi-language support

## Installation

1. Download the `docker-icon-manager.plg` file from the releases page
2. Go to Unraid's Plugins page
3. Click "Install Plugin" and select the downloaded plg file
4. Wait for the installation to complete
5. Refresh the page to see the new "Docker Icon Manager" menu item

## Usage

1. Open the Docker Icon Manager from the Unraid menu
2. Select a container from the dropdown list
3. Upload an icon file (PNG, JPEG, GIF, up to 2MB)
4. Click "Upload Icon" to set the icon
5. The icon will now appear in the Docker management interface

## How It Works

1. The plugin uploads your icon to `/var/lib/docker/unraid/images/` with the naming convention `container-name-icon.png`
2. It automatically creates a template file in `/boot/config/plugins/dockerMan/templates-user/` named `my-container-name.xml`
3. The Docker management interface will then recognize the icon for your container

## Requirements

- Unraid 6.0 or higher
- Docker service running
- PHP 7.0 or higher

## Troubleshooting

### Icon not showing up
- Try refreshing the Docker management page
- Restart the Docker service if necessary
- Check that the icon file was uploaded correctly to `/var/lib/docker/unraid/images/`
- Verify that the template file was created in `/boot/config/plugins/dockerMan/templates-user/`

### Upload failed
- Ensure the file is a valid image format (PNG, JPEG, GIF)
- Check that the file size is under 2MB
- Verify that you have write permissions to the icon directory

## Contributing

Pull requests and issues are welcome! Please see [CONTRIBUTING.md](CONTRIBUTING.md) for contribution guidelines.

## License

This project is licensed under the GNU General Public License v3.0 or later. See [LICENSE](LICENSE) for details.