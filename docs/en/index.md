---
title: Non-blocking File-based Sessions
summary: Non-blocking sessions allow you to have multiple requests using the same session running concurrently
icon: file
---

# Non-blocking file-based sessions

Make sure that your Silverstripe CMS installation has [`silverstripe/non-blocking-sessions`](https://github.com/silverstripe/silverstripe-non-blocking-sessions/) installed.

The default file-based session handler for PHP holds a lock on the session file while the session is open. This means that multiple concurrent requests from the same user have to wait for one another to finish processing after a session has been started. This includes AJAX requests.

This module provides file-based session handler that is *non-blocking*, which means that multiple concurrent requests from the same user don't have to wait for one another to finish.

> [!NOTE]
> The session save handler in this module differs from the default PHP file session handler in the following ways:
>
> 1. It doesn't lock the session file, and therefore doesn't block concurrent requests.
> 1. The [`Session.timeout`](api:SilverStripe\Control\Session->timeout) configuration property is used as the source of truth for the lifetime and garbage collection of session files.
> 1. If there are problems reading or writing to session files, the [default logging service](https://docs.silverstripe.org/en/developer_guides/debugging/error_handling/) is used to log them.

Note that in edge case scenarios, for example if your application wants to modify a session value *based on the value that is already set* and must do so for each request, non-blocking sessions may cause unexpected results.

> [!WARNING]
> This module is not compatible with [`silverstripe/hybridsessions`](https://packagist.org/packages/silverstripe/hybridsessions) or [`silverstripe/dynamodb`](https://packagist.org/packages/silverstripe/dynamodb).
