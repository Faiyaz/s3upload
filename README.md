# S3 Direct Upload
*Required javascript library* - **[Plupload](http://www.plupload.com/)** 
### Uploading files directly to AWS S3 Bucket.

I have added the full minimum version of the plupload js file along with the Moxie .swf and .xap files
To test it out, open the config file and plug in the AWS access key id, and AWS secret access key, 
plus name of an existing s3 bucket. S3 bucket should also have proper CORS Configuration setup. 

Below is an example of a Generic CORS setup for this demo.

```xml
<?xml version="1.0" encoding="UTF-8"?>
<CORSConfiguration xmlns="http://s3.amazonaws.com/doc/2006-03-01/">
    <CORSRule>
        <AllowedOrigin>*</AllowedOrigin>
        <AllowedMethod>GET</AllowedMethod>
        <AllowedMethod>POST</AllowedMethod>
        <AllowedMethod>PUT</AllowedMethod>
        <MaxAgeSeconds>3000</MaxAgeSeconds>
        <AllowedHeader>*</AllowedHeader>
    </CORSRule>
</CORSConfiguration>
```
