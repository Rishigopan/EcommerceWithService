//function to check if json
function TestJson(json) {
    var Untrimmed = json;
    var trimmed = Untrimmed.trim();

    if (typeof trimmed !== "string") {
        return false;
    }
    try {
        var NewJson = JSON.parse(trimmed);
        return typeof NewJson === "object";
    } catch (error) {
        return false;
    }
}