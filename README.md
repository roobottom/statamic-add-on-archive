# Statamic Archive add-on

A fast archive add-on for Statatmic. This add-on is designed to work alongside the Statamic `{{ entries:listing }}` tag to allow you to create a by-date list of your posts. For an example of what's possible, [see it use on my personal site](http://roobottom.com/archives).

It's fast as it doesn't read the content of files, rather it relies on Statamic's filename convension to scan your `_content` folders and return your posts in date order.

## Installing the add-on

This add-on is a single file, it should live in `_add-ons\archive\archive.php`. Put it there and it's ready to go.

## {{ archive:years }}

`{{ archive:years }}` returns a list of years for which you have posts.

### Sample Use

```
{{ archive:years folders="diary|gallery" }}
  <h1>There are {{ total }} entries</h1>
  {{ years }}
  	<h2>Entries in {{ year }}</h2>
  	<ul>
  	{{ entries:listing folder="diary|gallery" since="01-01-{ year }" until="31-12-{ year }" }}
  		<li>{{ title }}</li>
  	{{ /entries:listing }}
  	</ul>
  {{ /years }}
{{ /archive:years }}
```

### Parameters

`folders` (Required).

The folder(s) from which to pull entries. 

```
{{ archive:years folders="blog|photos" }}
```

`month_filter`

Return only years that have posts from a sepecific month. You can specify a month in numerical format, like `03` for March. Or, you can provide the `{ current_date }` variable. The add-on will then extract the current month.

If you use this parameter, you must remeber to specify the correct month in your `{{ entries:listing }}` parameters.

```
{{ archive:years folder="blog|photos" month_filter="03" }}
{{ archive:years folder="blog|photos" month_filter="{ current_date }" }}
```

### Available Variables

These variables are available inside `{{ archive:years}}`

`{{ total }}`

The total entries retured.

`{{ years }}{{ /years }}`

Loop of each year and, within this tag...

`{{ year }}`

You can use this in the following way (for example).

```
{{ years }}
  <ul>
  {{ entries:listing folder="diary" since="01-01-{ year }" until="31-12-{ year }" }}
    <li>{{ title }}</li>
  {{ /entries:listing }}
  </ul>
{{ /years }}
```
  
## {{ archive:months }}
  
Things get even more interesting when you throw `{{ archive:months }}` into the mix. 
  
### Sample Use
  
```
{{ archive:years folders="diary|gallery" }}
<h1>There are {{ total }} entries</h1>
{{ years }}
  <h2>Entries in {{ year }}</h2>
  {{ archive:months folders="diary|gallery" year="{ year }" }}
  <ul>
    {{ months }}
      <li>{{month_text}} has {{ count }} entries
        <ul>
        {{ entries:listing folder="diary|gallery" since="01-{month}-{year}" until="{days_in_month}-{month}-{year}" }}
          <li>{{ title }}</li>
        {{ /entries:listing }}
        </ul>
      </li>
    {{ /months }}
  </ul>
  {{ /archive:months }}
{{ /years }}
{{ /archive:years }}
```

### Parameters

`folders` (Required)

The folder from which you wish to pull entries.

`year` (Required)

The year from which you wish to pull entries.

### Available Variables

`{{ months }} {{ /months }}`

Loop of each month returned, within these...

`{{ month }}``

A numerical representation of the month, for example `04` for April.

`{{ month_text }}`

A full textual representation of the month, for example `April`

`{{ year }}`

The year returned for re-use.

`{{ days_in_month }}`

How many days are in this month.

`{{ count }}` 

A count of the posts returned in a particular months

## Issues, pull requests, etc.

Please report any issues. Pull requests welcome.

[Jon Roobottom](http://roobottom.com)
