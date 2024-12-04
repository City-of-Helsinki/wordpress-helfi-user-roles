# Helsinki User Roles

Custom user roles for Helsinki WordPress sites.

## Defined user roles

- **Helsinki Page Editor:** The user can manage their own media files and update pages assigned to them.

## Usage

Currently roles are added or updated during the plugin `activation_hook`. First deactivate and then reactivate the plugin to register new roles and modify existing ones.

Role descriptions are shown on the Users screen's help tab.

## About roles

- Roles must implement `Custom_Role_Interface`.
- Roles must be added to `$roles` array in `Custom_Roles_Factory` during the factory setup.
- `Custom_Roles_Factory` must have a factory method for every role.
