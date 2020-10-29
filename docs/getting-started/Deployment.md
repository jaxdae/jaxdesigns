# Deployments

This document describes the default deployment-pipelines available for the boilerplate.

## Buddy.works - CI/CD

Deployments are managed by [buddy.works].
The configuration can be found in the `buddy.yml` file in the root folder.
Please check and adjust as needed for your project.

## Deployment Configuration

Update the following settings:

- **Staging**
  - `ref_name`: the branch, usually `develop`
  - `target_site_url`: staging url of the project
  - Action *Execute: Run Composer*, *Execute: Run NPM  in Theme*:
    - `working_directory`: usually `/buddy/repo-name`
    - `mount_filesystem_path`: usually `/buddy/repo-name`
  - Action *Upload to Staging*:
    - `remote_path`: path/to/your/project/on/the/ftp/server/
- **Production**
  - same as **Staging** except you don't have to change the `ref_name`-setting
  - set `trigger_mode` to `ON_EVERY_PUSH` for automatic-deployment to production

## Initial Setup

Please login to [buddy.works] and add a project with the corresponding repository.

### Steps

- login to [buddy.works]
- create a new project
  - also add the project into a own folder for the customer who we are working for
- create the project specific env-variables
- set the pipeline configuration to YML
- add your `buddy.yml` file to the repo
- the pipelines will show up as soon as the first pipeline run is triggered

## Good to know

- we can exclude not-needed files for all the stages
  - example are some config-files like `.eslintignore` and similar
  - please check back with the team while setting up the pipelines and optimize
  - the clenaer the stages the better for maintenance and security for us

[buddy.works]: https://app.buddy.works/towa
