<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Write News</title>
</head>
<body>
    <form id="news">
        <p>Please enter your news</p>
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required>
        <label for="content">Content:</label>
        <textarea name="content" id="content" cols="30" rows="10" required></textarea>
        <input type="submit" value="Submit" name="submit">
        <label for="date">Date:</label>
        <input type="date" name="date" id="date" required>
        <label for="category">Category:</label>
        <select id="category" name="category">
            <option value="Sport">Sport</option>
            <option value="Politics">Politics</option>
            <option value="Economy">Economy</option>
            <option value="weather">Weather</option>
            <option value="celebrities">Celebrities</option>
            <option value="dailynews">Daily News</option>
        </select>
    </form>
</body>
</html>