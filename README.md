# Statamic Archive add-on

A fast archive add-on for Statatmic. This add-on is designed to work alongside the Statamic `{{ entries:lisiting }}` tag to allow you to create a by-date list of your posts. For an example of what's possible, [see it use on my personal site](http://roobottom.com/archives).

It's fast as it doesn't read the content of files, rather it relies on Statamic's filename convension to scan your `_content` folders and return your posts in date order.

## Installing the add-on

This add-on is a single file, it should live in `_add-ons\archive\archive.php`. Put it there and it's ready to go.

## Sample Useage

```
{{ archive:years folder="blog|photos" }}
  <h2>There are {{ total }} entries for {{year}}</h2>
  
{{ /archive:years }}
```

## {{ archive:years }}

`{{ archive:years }}` returns a list of years for which you have posts.

### Parameters

`folder` 

The folder from which to pull entries.

```
{{ archive:years folder="blog|photos" }}

{{ /archive:years }}
```

