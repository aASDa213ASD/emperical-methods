// commands.js
const directory_passthrough = [
    "/",
    "about",
    "system",
];

const commands_passthrough = [
    "probability",
    "ls"
];

document.querySelector("form").onsubmit = async function(e)
{
    const input = document.querySelector('textarea[name="command"]'); 
    const cmd = input.value.split(' ', 1);

    submitForm = false;
    e.preventDefault();

    switch(cmd[0].toLowerCase())
    {
        case "cd":
            if (cmd.length > 1 && directory_passthrough.includes(cmd[1].trim()) || cmd.length === 1)
                submitForm = true;
            else
                throw_invalid_route(cmd[1]);
            break;
        case "help":
            fetch_async("/help");
            break;
        case "about":
            fetch_async("/about");
            break;
        case "clear":
            clear_terminal();
            break;
        default:
            if (!commands_passthrough.includes(cmd[0].trim()))
                throw_command_not_found(cmd[0])
            else
                submitForm = true;
    }

    if (submitForm) e.target.submit()
    else input.value = "";

    update_caret_position();
}

function update_caret_position()
{
    const textarea = document.getElementById('command_input');
    const caret = document.getElementById('custom_caret');

    const textWidth = get_text_width(textarea.value, window.getComputedStyle(textarea).font);
    const textareaRect = textarea.getBoundingClientRect();

    caret.style.left = (textWidth + textareaRect.left - 40) + 'px'; // Adjust 5 pixels for better alignment
}

function get_text_width(text, font)
{
    const canvas = get_text_width.canvas || (get_text_width.canvas = document.createElement("canvas"));
    const context = canvas.getContext("2d");
    context.font = font;
    const metrics = context.measureText(text);
    return metrics.width;
}

function clear_terminal()
{
    const initial_message = document.getElementById("initial_message");
    const output = document.getElementById("command_output");

    try { initial_message.innerHTML = ""; } 
    catch (error) {}

    try { output.innerHTML = ""; } 
    catch (error) {}
}

async function fetch_async(route)
{
    const response = await fetch(route);
    const text = await response.text();
    const output = document.getElementById("command_output");
    output.innerHTML = output.innerHTML + text;
}

function throw_invalid_route(route)
{
    const text = "<p class='text-description'>Route '" + route + "' does not exist</p>";
    const output = document.getElementById("command_output");
    output.innerHTML = output.innerHTML + text;
}

function throw_command_not_found(command)
{
    if (command === '') 
        return;
    
    const output = document.getElementById("command_output");
    const text = "<div class='mt-2'><pre class='text-description'>Command <span class=text-command>'" + command + "'</span> not found. For a list of commands, type <span class='text-command'>'help'</span></pre></div>";
    output.innerHTML = output.innerHTML + text;
}

function validate_credentials(username, password)
{
    const jsonFilePath = 'static/json/users.json';

    return fetch(jsonFilePath)
        .then(response => response.json())
        .then(credentials => {
            const user = credentials.users.find(user => user.username === username && user.password === password);
            return Boolean(user);
        })
        .catch(error => {
            console.error('Error fetching JSON file:', error);
            return false;
        });
}

function handle_enter_command(event)
{
    if (event.key === "Enter")
    {
        event.preventDefault();
        document.getElementById("shell").dispatchEvent(new Event("submit"));
    }
}