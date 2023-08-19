<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" 
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:fo="http://www.w3.org/1999/XSL/Format">
    
    <xsl:key name="categories" match="event" use="category" />
    <!-- "/" indicate that template is applied to the root node of xml file -->
    <xsl:template match="/">
        <html>
            <head>
                <title>Popular Category Report</title>
                <link rel="stylesheet" type="text/css" href="../../config/site_css_links.php"/>
                <style>
                    table {
                    text-align: center;
                    border-collapse: collapse;
                    width: 100%;
                    font-family: Calibri, sans-serif;
                    }

                    th, td {
                    background-color:white;
                    padding: 8px;
                    border: 1px solid black;
                    }

                    th { 
                    font-weight: bold;
                    }

                    h2, small {
                    font-family: Calibri, sans-serif;
                    }
                    
                    small{
                    font-weight: bold;
                    }
                </style>
            </head>
            <body>
                <h2>Top 5 most popular category</h2>
                <table border="1">
                    <tr>
                        <th>No.</th>
                        <th>Category Name</th>
                        <th>Total number of events created</th>
                        <th>Total number of active events</th>
                    </tr>
                    <!-- Declare a variable to store the counter value -->
                    <xsl:variable name="counter" select="0"/>
                    <!-- Use for each loop to iterate the role element inside the 
                    root tag   -->
                    <xsl:for-each select="//event[generate-id(.)=generate-id(key('categories', category)[1])]">
                        <xsl:sort select="count(key('categories', category)[status = 'Active'])" order="descending" />
                        <xsl:if test="position() &lt;= 5">
                            <tr>
                                <td>
                                    <!-- Use the position() function to get the current position
                                    and add the counter value to it -->
                                    <xsl:value-of select="$counter + position()"/>
                                </td>
                            
                                <td>
                                    <xsl:value-of select="category"/>
                                </td>
                            
                                <td>
                                    <xsl:value-of select="count(key('categories', category))"/>
                                </td>
                            
                                <td>
                                    <xsl:value-of select="count(key('categories', category)[status = 'Active'])"/>
                                </td>
                            </tr>
                        </xsl:if>
                    </xsl:for-each>
                </table>
                <footer>
                    <small>Generated by Japanese Online Ticketing System</small>
                </footer>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>