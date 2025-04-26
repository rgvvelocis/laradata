<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class XSS
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $input = $request->all();
        
         return $next($request);

        // Sanitize input recursively for all fields
        array_walk_recursive($input, function(&$value, $key) {
           
            if (strpos($key, 'agreement_text') !== false) {
                return; // Skip sanitizing if it's from a textarea field
                 
            }

            // Using str_ireplace to avoid case sensitivity issues
            $value = str_ireplace('<?php', '', $value);
            $value = str_ireplace('script', '', $value);
            $value = str_ireplace('alert', '', $value);
            $value = str_ireplace('prompt', '', $value);
            $value = str_ireplace('onmouseover', '', $value);
            $value = str_ireplace('onmouseovEr', '', $value);
            $value = str_ireplace('javascript', '', $value);

            // Optional: Remove unsafe HTML tags (e.g., <script>, <iframe>)
            $value = strip_tags($value);

            // Further sanitization if needed
            $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); // Convert special characters to HTML entities
        });

        // Merge sanitized inputs back into the request
        $request->merge($input);

        return $next($request);
    }
}
