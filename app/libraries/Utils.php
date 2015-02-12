<?php

Class Utils
{

    /**
     * Simple return an array of Simple API Headers
     *
     * @param int $count
     * @return array
     */
    public static function getApiHeaders($count = 0)
    {
        return array(
            'Content-Type' => 'application/json',
            //'Access-Control-Allow-Origin' => '*',
            //'Access-Control-Allow-Methods' => 'GET',
            //'Access-Control-Allow-Headers' => 'Origin, Content-Type, Accept, Authorization, X-Requested-With',
            //'Access-Control-Allow-Credentials' => 'true',
            'X-Total-Count' => $count,
            //'X-Rate-Limit-Limit' - The number of allowed requests in the current period
            //'X-Rate-Limit-Remaining' - The number of remaining requests in the current period
            //'X-Rate-Limit-Reset' - The number of seconds left in the current period,
        );
    }

    /**
     * A loop calling of where function with the specified array
     *
     * @param $query - Eloquent
     * @param array $where - Key value pairs
     */
    public static function doCarModelWhere($query, $where = array())
    {
        if ($query) {
            if (count($where) > 0) {
                foreach ($where as $w_key => $w_value) {
                    if (!is_null(trim($w_value))) {
                        $query->where($w_key, $w_value);
                    }
                }
            }
        }
    }

    /**
     * Most common salutations
     *
     * @return array
     */
    public static function getSalutations()
    {
        return array(
            'Ms' => 'Ms',
            'Mr' => 'Mr',
            'Mrs' => 'Mrs',
            'Dr' => 'Dr',
            'Prof' => 'Prof',
        );
    }

    /**
     * Base Path Helper
     *
     * @return string
     */
    public static function basePath()
    {
        return substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/') + 1);
    }


    public static function trans($input)
    {
        $data = [];

        foreach ($input as $field) {
            if ($field == "checkbox") {
                $data[] = $field;
            } else {
                $data[] = trans("texts.$field");
            }
        }

        return $data;
    }

    public static function parseFloat($value)
    {
        $value = preg_replace('/[^0-9\.\-]/', '', $value);
        return floatval($value);
    }

    public static function formatPhoneNumber($phoneNumber)
    {
        $phoneNumber = preg_replace('/[^0-9a-zA-Z]/', '', $phoneNumber);

        if (!$phoneNumber) {
            return '';
        }

        if (strlen($phoneNumber) > 10) {
            $countryCode = substr($phoneNumber, 0, strlen($phoneNumber) - 10);
            $areaCode = substr($phoneNumber, -10, 3);
            $nextThree = substr($phoneNumber, -7, 3);
            $lastFour = substr($phoneNumber, -4, 4);

            $phoneNumber = '+' . $countryCode . ' (' . $areaCode . ') ' . $nextThree . '-' . $lastFour;
        } else if (strlen($phoneNumber) == 10 && in_array(substr($phoneNumber, 0, 3), array(653, 656, 658, 659))) {
            /**
             * SG country code are 653, 656, 658, 659
             * US area code consist of 650, 651 and 657
             * @see http://en.wikipedia.org/wiki/Telephone_numbers_in_Singapore#Numbering_plan
             * @see http://www.bennetyee.org/ucsd-pages/area.html
             */
            $countryCode = substr($phoneNumber, 0, 2);
            $nextFour = substr($phoneNumber, 2, 4);
            $lastFour = substr($phoneNumber, 6, 4);

            $phoneNumber = '+' . $countryCode . ' ' . $nextFour . ' ' . $lastFour;
        } else if (strlen($phoneNumber) == 10) {
            $areaCode = substr($phoneNumber, 0, 3);
            $nextThree = substr($phoneNumber, 3, 3);
            $lastFour = substr($phoneNumber, 6, 4);

            $phoneNumber = '(' . $areaCode . ') ' . $nextThree . '-' . $lastFour;
        } else if (strlen($phoneNumber) == 7) {
            $nextThree = substr($phoneNumber, 0, 3);
            $lastFour = substr($phoneNumber, 3, 4);

            $phoneNumber = $nextThree . '-' . $lastFour;
        }

        return $phoneNumber;
    }

    public static function formatMoney($value, $currencyId = false)
    {
        if (!$currencyId) {
            $currencyId = Session::get(SESSION_CURRENCY);
        }

        $currency = Currency::remember(DEFAULT_QUERY_CACHE)->find($currencyId);

        if (!$currency) {
            $currency = Currency::remember(DEFAULT_QUERY_CACHE)->find(1);
        }

        return $currency->symbol . number_format($value, $currency->precision, $currency->decimal_separator, $currency->thousand_separator);
    }

    public static function pluralize($string, $count)
    {
        $field = $count == 1 ? $string : $string . 's';
        $string = trans("texts.$field", ['count' => $count]);
        return $string;
    }

    public static function toArray($data)
    {
        return json_decode(json_encode((array)$data), true);
    }

    public static function toSpaceCase($camelStr)
    {
        return preg_replace('/([a-z])([A-Z])/s', '$1 $2', $camelStr);
    }

    /**
     * timestamp datetime to client prefered formatted
     *
     * @param $timestamp
     * @return string
     */
    public static function timestampToDateTimeString($timestamp)
    {
        $timezone = Session::get(SESSION_TIMEZONE, conf('user::default_timezone'));
        $date_format = Session::get(SESSION_DATE_FORMAT, conf('admin::default_datetime_format'));
        $time_format = Session::get(SESSION_TIME_FORMAT, conf('user::default_time_format'));

        $format = $date_format . ' ' . $time_format;
        return Utils::timestampToString($timestamp, $timezone, $format);
    }

    /**
     * timestamp date to client prefered formatted
     *
     * @param $timestamp
     * @return string
     */
    public static function timestampToDateString($timestamp)
    {
        $timezone = Session::get(SESSION_TIMEZONE, conf('user::default_timezone'));
        $format = Session::get(SESSION_DATE_FORMAT, conf('user::default_date_format'));
        return Utils::timestampToString($timestamp, $timezone, $format);
    }

    /**
     * DB Date to client prefered formatted
     *
     * @param $date
     * @return string
     */
    public static function dateToString($date)
    {
        $dateTime = new DateTime($date);
        $timestamp = $dateTime->getTimestamp();
        $format = Session::get(SESSION_DATE_FORMAT, conf('user::default_date_format'));
        return Utils::timestampToString($timestamp, false, $format);
    }

    /**
     * Format timestamp to string
     *
     * @param $timestamp
     * @param bool $timezone
     * @param $format
     * @return string
     */
    public static function timestampToString($timestamp, $timezone = false, $format)
    {
        if (!$timestamp) {
            return '';
        }
        $date = Carbon::createFromTimeStamp($timestamp);
        if ($timezone) {
            $date->tz = $timezone;
        }

        if ($date->year < 1900) {
            return '';
        }

        return $date->format($format);
    }

    /**
     * Client Date Input To System Timezone
     *
     * @param $date
     * @param bool $formatResult
     * @return DateTime|null|string
     */
    public static function toSqlDate($date, $formatResult = true)
    {
        if (!$date) {
            return null;
        }

        $timezone = Session::get(SESSION_TIMEZONE);
        $format = Session::get(SESSION_DATE_FORMAT);

        $dateTime = DateTime::createFromFormat($format, $date, new DateTimeZone($timezone));
        return $formatResult ? $dateTime->format('Y-m-d') : $dateTime;
    }

    /**
     * Client Date Input To System Timezone
     *
     * @param $date
     * @param bool $formatResult
     * @return DateTime|string
     */
    public static function fromSqlDate($date, $formatResult = true)
    {
        // if date or datetime is all 00 ?
        if (!$date || $date == '0000-00-00' || $date == '0000-00-00 00:00:00') {
            return NULL;
        }
        $timezone = Session::get(SESSION_TIMEZONE);
        $format = Session::get(SESSION_DATE_FORMAT);

        $dateTime = DateTime::createFromFormat('Y-m-d', $date, new DateTimeZone($timezone));

        return $formatResult ? $dateTime->format($format) : $dateTime;
    }


    public static function formatDateTime($timestamp)
    {
        return date('Y-m-d g:i s', $timestamp);
    }

    public static function today($formatResult = true)
    {
        $timezone = Session::get(SESSION_TIMEZONE);
        $format = Session::get(SESSION_DATE_FORMAT);
        $date = date_create(null, new DateTimeZone($timezone));

        if ($formatResult) {
            return $date->format($format);
        } else {
            return $date;
        }
    }

    private static function getDatePart($part, $offset)
    {
        $offset = intval($offset);
        if ($part == 'MONTH') {
            return Utils::getMonth($offset);
        } else if ($part == 'QUARTER') {
            return Utils::getQuarter($offset);
        } else if ($part == 'YEAR') {
            return Utils::getYear($offset);
        }
    }

    private static function getMonth($offset)
    {
        $months = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"];

        $month = intval(date('n')) - 1;

        $month += $offset;
        $month = $month % 12;

        if ($month < 0) {
            $month += 12;
        }

        return $months[$month];
    }

    private static function getQuarter($offset)
    {
        $month = intval(date('n')) - 1;
        $quarter = floor(($month + 3) / 3);
        $quarter += $offset;
        $quarter = $quarter % 4;
        if ($quarter == 0) {
            $quarter = 4;
        }
        return 'Q' . $quarter;
    }

    public static function csvDownload($file_name = "csv", $data, $header)
    {
        // Load csv parser
        require_once(app_path() . '/includes/parsecsv.lib.php');
        $csv = new parseCSV();

        $file_ex = '.csv';
        $full_file_name = $file_name . $file_ex;

        // Send Proper Output header
        $csv->output(true, $full_file_name, $data, $header);
        exit();
    }


    /**
     * Display A fatal error page
     *
     * @param string $message
     * @param string $exception
     * @param string $view
     * @return $this
     */
    public static function fatalError($message = null, $exception = null, $view = 'error')
    {
        $message = (!empty($message)) ? $message : lang('texts.internal_error');
        self::logError($message . ' ' . $exception);

        $data = array(
            'error' => $message
        );

        return View::make($view)->with($data);
    }

    /**
     * Loggers
     *
     * @param string $error
     * @param string $context
     * @return void
     */
    public static function logError($error, $context = 'PHP')
    {
        $count = Session::get('error_count', 0);
        Session::put('error_count', ++$count);

        if ($count > 100) {
            return 'logged';
        }

        $data = array(
            'context' => $context,
            'user_id' => (user_check() ? user_get()->id : 0),
            'user_name' => (user_check() ? user_get()->present()->getDisplayName() : ''),
            'url' => Input::get('url', Request::url()),
            'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '',
            'ip' => Request::getClientIp(),
            'count' => Session::get('error_count', 0)
        );

        Log::error($error . "\n", $data);

        /*
        Mail::queue('emails.error', ['message'=>$error.' '.json_encode($data)], function($message)
        {
            $message->to($email)->subject($subject);
        });
        */
    }


    /**
     * Validate if the posted array is qualified for
     * bulk actions
     *
     * @param string $input_name - The input name that contains the array to validate
     * @param bool $destroy - Should be destroy and return back?
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    public static function validateBulkArray($input_name, $destroy = true)
    {
        if (!Input::has($input_name)
            || !is_array(Input::get($input_name))
            || count(Input::get($input_name)) <= 0
        ) {
            if ($destroy) {
                App::abort('500');
            }

            return FALSE;
        }

        return TRUE;
    }

    public static function getPlacesDetailsFormatted($place_id)
    {

        $details = self::getPlacesDetails($place_id);
        if (empty($details)) {
            return FALSE;
        }

        $place_id = array_get($details, 'place_id');
        $lat = array_get($details, 'geometry.location.lat');
        $lng = array_get($details, 'geometry.location.lng');
        $display_text = array_get($details, 'display_text');
        $formatted_address = array_get($details, 'formatted_address');
        $locality = '';
        $admin2 = '';
        $admin1 = '';
        $country = '';
        $country_iso2 = '';

        foreach (array_get($details, 'address_components', array()) as $address_item) {
            $type = array_get($address_item, 'types.0', NULL);

            switch ($type) {
                case 'locality':
                    $locality = array_get($address_item, 'long_name');
                    break;
                case 'administrative_area_level_2':
                    $admin2 = array_get($address_item, 'long_name');
                    break;
                case 'administrative_area_level_1':
                    $admin1 = array_get($address_item, 'long_name');
                    break;
                case 'country':
                    $country = array_get($address_item, 'long_name');
                    $country_iso2 = array_get($address_item, 'short_name');
                    break;
            }
        }

        return array(
            'place_id' => $place_id,
            'lat' => $lat,
            'lng' => $lng,
            'formatted_address' => $formatted_address,
            'locality' => $locality,
            'admin2' => $admin2,
            'admin1' => $admin1,
            'country' => $country,
            'country_iso2' => $country_iso2,
        );
    }

    /**
     * Automatically reorder nestable from table
     *
     * @param string    $whichObject    which object to initilize (i.e 'Menu' or 'Model\Menu')
     * @param array     $reordersData   the reorder data '[[id:2,children:[[id:3][id:4,children:[[id6]]]]]]
     * @param int       $parent         The default parent
     * @param string    $sortOrder      The short order column name
     * @param string    $parentColumn   the parent column name
     */
    public static function updateNestable($whichObject, $reordersData = array(), $parent = 0, $sortOrder = "sort", $parentColumn = "parent")
    {
        if ( ! empty($reordersData)) {
            foreach ($reordersData as $index => $reorderData) {
                $parentId = array_get($reorderData, 'id');
                $Order = $whichObject::find($parentId);

                // if found, then update sort index
                if ($Order) {
                    $Order->{$sortOrder} = $index;

                    // parent is optional
                    if (!empty($parentColumn))
                    {
                        $Order->{$parentColumn} = $parent;
                    }

                    $Order->save();
                }

                $children = array_get($reorderData, 'children');

                self::updateNestable($whichObject, $children, $parentId, $sortOrder, $parentColumn);
            }
        }
    }

    /**
     * When a nestable table row is deleted and has a child on it
     * then we need to empty its child column to its parent recursively
     *
     * @param string    $whichObject    which object to initilize (i.e 'Menu' or 'Model\Menu')
     * @param int       $parentId       The parent id of the deleted group
     * @param int       $newPosition    new sort value
     * @param string    $sortOrder      The short order column name
     * @param string    $parentColumn   the parent column name
     */
    public static function emptyParentNestable($whichObject, $parentId, $newPosition = 0, $sortOrder = "sort", $parentColumn = "parent")
    {
        $Orders = $whichObject::where($parentColumn, $parentId)->get();
        foreach ($Orders as $Order)
        {
            $Order->$parentColumn = 0;
            $Order->$sortOrder = $newPosition;
            $Order->save();

            self::emptyParentNestable($whichObject, $Order->id, $newPosition, $sortOrder, $parentColumn);
        }
    }

}