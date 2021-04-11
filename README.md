# Video parser

This is a little plugin to get the ID from a youtube of vimeo URL, so that it can be used to create a video embed.

## Usage

The plugin comes with a twig function that you use like this:
````
{% set video = craft.videoparser.parse(entry.video) %}
````
It returns an object with the following properties:
- Type (youtube or vimeo)
- ID
- embedSrc (specific to the type)

Then you can create your own embed as you see fit.

````
<iframe src="{{ video.embedSrc }}" frameborder="0" width="500" height="300"></iframe>
````
