const chatbotToggler = document.querySelector(".chatbot-toggler");
const closeBtn = document.querySelector(".close-btn");
const chatbox = document.querySelector(".chatbox");
const chatInput = document.querySelector(".chat-input textarea");
const sendChatBtn = document.querySelector(".chat-input span");

const inputInitHeight = chatInput.scrollHeight;
let chatResetTimer;

const createChatLi = (message, className) => {
    const chatLi = document.createElement("li");
    chatLi.classList.add("chat", `${className}`);
    let chatContent = className === "outgoing" ? `<p></p>` : `<span class="material-symbols-outlined">smart_toy</span><p></p>`;
    chatLi.innerHTML = chatContent;
    chatLi.querySelector("p").textContent = message;
    return chatLi;
}

const generateResponse = (chatElement,userMessage) => {
    userMessage =userMessage.toLowerCase();
    const messageElement = chatElement.querySelector("p");

    setTimeout(() => {
        let botResponse;
        let buttonsHTML = "";

        if (userMessage.includes("hello") || userMessage.includes("hi") || userMessage.includes("hey")) {
            botResponse = "Hello! How can I assist you today?";
        } else if (userMessage.includes("help")) {
            botResponse = "Sure, I'm here to help. What do you need assistance with?";
            buttonsHTML = `<button class="response-btn" data-response="Navigation">Navigation</button>
            <button class="response-btn" data-response="Give feedback">Give feedback</button>
            <button class="response-btn" data-response="bot commands">Bot commands</button>
            <button class="response-btn" data-response="faq">FAQ</button>`;
        } else if (userMessage.includes("support")) {
            botResponse = "What would you like our assistance with?";
            buttonsHTML = `<button class="response-btn" data-response="customer care">Customer care</button>
            <button class="response-btn" data-response="report bugs">Report bugs</button>
            <button class="response-btn" data-response="social">Socials</button>
            <button class="response-btn" data-response="about me">About me</button>`;
        } else if (userMessage.includes("how are you")) {
            botResponse = "I'm just a computer program, but thanks for asking!";
        } else if (userMessage.includes("navigation")) {
            botResponse = "Sure, where would you like to go?";
            buttonsHTML = `<button class="response-btn" data-response="home">Home</button>
                <button class="response-btn" data-response="login">Login</button>
                <button class="response-btn" data-response="feedback">feedback page</button>`;
        } else if (userMessage.includes("bot commands")) {
            botResponse = "There are number of commands you can try here, these are:\nHelp\nSupport\nNavigation\nBot commands\nCustomer care";
        } else if (userMessage.includes("customer care")) {
            botResponse = "How would you like to connect to us?";
            buttonsHTML = `<button class="response-btn" data-response="mail">Mail</button>
                <button class="response-btn" data-response="number">Number</button>
                <button class="response-btn" data-response="live chat">Live chat</button>`;
        } else {
            botResponse = "I'm sorry, I didn't understand that. Can you please rephrase?";
        }

        messageElement.textContent = botResponse;
        chatbox.scrollTo(0, chatbox.scrollHeight);

        if (buttonsHTML) {
            const buttonsContainer = document.createElement("div");
            buttonsContainer.classList.add("bot-buttons");
            buttonsContainer.innerHTML = buttonsHTML;
            chatbox.appendChild(buttonsContainer);
            chatbox.scrollTo(0, chatbox.scrollHeight);

            const responseButtons = buttonsContainer.querySelectorAll(".response-btn");
            responseButtons.forEach((button) => {
                button.addEventListener("click", () => handleResponseButtonClick(buttonsContainer, chatbox, button.dataset.response));
            });
        }
    }, 500);
};

const handleResponseButtonClick = (rmbtn, chatbox, response) => {
    const newChatLi = createChatLi("Thinking...", "incoming");

    let newButtonsHTML = "";
    if (response) {
        switch (response.toLowerCase()) {
            case "navigation":
                setTimeout(()=>{newChatLi.querySelector("p").textContent = "Sure, let me assist you with navigation. Where would you like to go?";},500);
                newButtonsHTML = `<button class="new-response-btn" data-response="home">Home</button>
                <button class="new-response-btn" data-response="login">Login</button>
                <button class="new-response-btn" data-response="feedback">feedback page</button>`;
                break;
            case "give feedback":
                setTimeout(() => {
                    const link = document.createElement("a");
                    link.href = "fullfeedback/fullfeedback.html";
                    link.textContent = "We appreciate your feedback! Please let us know your thoughts, visit the feedback page click here";
                    newChatLi.querySelector("p").innerHTML = ""; 
                    newChatLi.querySelector("p").appendChild(link);
                }, 500);
                break;
            case "bot commands":
                setTimeout(()=>{newChatLi.querySelector("p").textContent = "Sure, there are number of commands you can try here, these are:\nHelp\nSupport\nNavigation\nBot commands";},500); break;
            case "home":
                    setTimeout(() => {
                        const link = document.createElement("a");
                        link.href = "index.php";
                        newChatLi.querySelector("p").innerHTML = "To go to Home page, click "; 
                        link.textContent = "here.";
                        newChatLi.querySelector("p").appendChild(link);
                    }, 500);
                    break;
            case "login":
                setTimeout(() => {
                    const link = document.createElement("a");
                    link.href = "login/login.html";
                    newChatLi.querySelector("p").innerHTML = "To go to login page, click "; 
                    link.textContent = "here.";
                    newChatLi.querySelector("p").appendChild(link);
                }, 500);
                break;
            case "feedback":
                setTimeout(() => {
                    const link = document.createElement("a");
                    link.href = "fullfeedback/fullfeedback.html";
                    newChatLi.querySelector("p").innerHTML = "To go to feedback page, click "; 
                    link.textContent = "here.";
                    newChatLi.querySelector("p").appendChild(link);
                }, 500);
                break;
            case "customer care":
                setTimeout(()=>{newChatLi.querySelector("p").textContent = "How would you like to connect to us?";},500);
                newButtonsHTML = `<button class="new-response-btn" data-response="mail">Mail</button>
                <button class="new-response-btn" data-response="number">Number</button>
                <button class="new-response-btn" data-response="live chat">Live chat</button>`;
                break;
            case "mail":
                setTimeout(()=>{newChatLi.querySelector("p").textContent = "Do you want to connect to us through mail?";},500);
                newButtonsHTML = `<button class="new-response-btn" data-response="yes">Yes</button>
                <button class="new-response-btn" data-response="no">No</button>`;
                break;
            case "yes":
                setTimeout(()=>{newChatLi.querySelector("p").textContent = "Sure, you can connect to us at customercare@example.com";},500); break;
            case "yes2":
                setTimeout(()=>{newChatLi.querySelector("p").textContent = "Sure, you can connect to us at +911045033354";},500); break;
            case "no":
                setTimeout(()=>{newChatLi.querySelector("p").textContent = "Type \"customer care\" to select the mode of connection again.";},500); break;
            case "number":
                setTimeout(()=>{newChatLi.querySelector("p").textContent = "Do you want to connect to us through number?";},500);
                newButtonsHTML = `<button class="new-response-btn" data-response="yes2">Yes</button>
                <button class="new-response-btn" data-response="no">No</button>`;
                break;
            case "live chat":
                setTimeout(()=>{newChatLi.querySelector("p").textContent = "No agent available at the moment.";},500); break;
            case "faq":
                setTimeout(()=>{newChatLi.querySelector("p").textContent = "Here are some Frequently Asked Questions:";},500);
                faqA= "Is my feedback Truly anonymous?\n\nAnswer: Yes, It is completely anonymous as even the meta data of feedback providers isn't taken by our system.";
                faqB= "I recieved an SMS leading me to a feedback website, is it safe?\n\nAnswer: Yes, it is completely safe, we will be grateful if you could give some of your valuable time giving that short feedback.";
                faqC= "Can I file complaints online through this website?\n\nAnswer: No, this website is, for now, only for feedbacks to get a general idea of people's opinion, we might add such feature in the future. We do, however, have option to report problems faced while using the website. Feel free to leave your veiws in the \"Report bugs\" section";
                const FAQAChatli = createChatLi("thinking...", "incoming");
                setTimeout(() => {
                    FAQAChatli.querySelector("p").textContent = faqA;
                    const FAQBChatli = createChatLi(faqB, "incoming");
                    const FAQCChatli = createChatLi(faqC, "incoming");
                    chatbox.appendChild(FAQAChatli);
                    chatbox.appendChild(FAQBChatli);
                    chatbox.appendChild(FAQCChatli);
                },500);
                break;
                case "social":
                setTimeout(()=>{newChatLi.querySelector("p").textContent = "You can follow us at instagram, twitter, and facebook!\nInstagram -> @RJ.Police.Feedback\nFacebook -> @RJPolice.feedback\nTwitter -> @Feedback.RJPolice";},500); break;
            case "about me":
                setTimeout(()=>{newChatLi.querySelector("p").textContent = "I am chatbot designed to help all the user visiting our site in any way I can.\n\nFeel free to ask anything.";},500); break;
            case "report bugs":
                setTimeout(()=>{newChatLi.querySelector("p").textContent = "If you spot any bugs, click here to report them. We're committed to fixing issues promptly. Thanks for your help!";},500); break;
            default: break;        
        }
    }
    if (rmbtn) {
        rmbtn.remove();
    }
    chatbox.appendChild(newChatLi);
    setTimeout(()=>{
        if (newButtonsHTML) {
            const buttonsContainer = document.createElement("div");
            buttonsContainer.classList.add("bot-buttons");
            buttonsContainer.innerHTML = newButtonsHTML;
            chatbox.appendChild(buttonsContainer);
            chatbox.scrollTo(0, chatbox.scrollHeight);

            const responseButtons = buttonsContainer.querySelectorAll(".new-response-btn");
            responseButtons.forEach((button) => {
                button.addEventListener("click", () => handleResponseButtonClick(buttonsContainer, chatbox, button.dataset.response));
            });
        }
    },500);
    chatbox.scrollTo(0, chatbox.scrollHeight);
};

const removeBotButtons = () => {
    const botButtons = chatbox.querySelector(".bot-buttons");
    if (botButtons) {
        botButtons.remove();
    }
};

const resetChat = () => {
    chatbox.innerHTML = ""; 
    const incomingChatLi = createChatLi("Thinking...", "incoming");
    chatbox.appendChild(incomingChatLi);
    setTimeout(()=>{
        userMessage = "Due to inactivity we are closing this session, feel free to message again."
        incomingChatLi.querySelector('p').textContent=userMessage;
    },500)
};

const handleChat = () => {
    const userMessage = chatInput.value.trim();
    if (!userMessage) return;
    
    chatInput.value = "";
    chatInput.style.height = `${inputInitHeight}px`;

    removeBotButtons()

    chatbox.appendChild(createChatLi(userMessage, "outgoing"));
    chatbox.scrollTo(0, chatbox.scrollHeight);

    setTimeout(() => {
        const incomingChatLi = createChatLi("Thinking...", "incoming");
        chatbox.appendChild(incomingChatLi);
        chatbox.scrollTo(0, chatbox.scrollHeight);
        generateResponse(incomingChatLi,userMessage);
    }, 500);

    clearTimeout(chatResetTimer);
    chatResetTimer = setTimeout(() => {
        resetChat();
    }, 60000);

};

chatInput.addEventListener("input", () => {
    chatInput.style.height = `${inputInitHeight}px`;
    chatInput.style.height = `${chatInput.scrollHeight}px`;
});

chatInput.addEventListener("keydown", (e) => {
    if (e.key === "Enter" && !e.shiftKey && window.innerWidth > 800) {
        e.preventDefault();
        handleChat();
    }
});

sendChatBtn.addEventListener("click", handleChat);
closeBtn.addEventListener("click", () => document.body.classList.remove("show-chatbot"));
chatbotToggler.addEventListener("click", () => document.body.classList.toggle("show-chatbot"));
