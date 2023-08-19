<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <xsl:template match="/">
        <html>
            <head>
                <title>orderDetails.xsl</title>
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
                <h2>Order Detail</h2>
                <table border="1">
                    <tr>
                        <th>Order Detail Id</th>
                        <th>Order Id</th>
                        <th>Ticket Code</th>
                    </tr>
                    <xsl:for-each select="OrderDetails/orderDetail">
                        <tr>
                            <td>
                                <xsl:value-of select="id"/>
                            </td>
                            
                            <td>
                                <xsl:value-of select="order"/>
                            </td>
                            
                            <td>
                                <xsl:value-of select="code"/>
                            </td>
                        </tr>
                    </xsl:for-each>
                </table>
                <footer>
                    <small>Generated by Japanese Online Ticketing System</small>
                </footer>
            </body>
        </html>
    </xsl:template>

</xsl:stylesheet>
